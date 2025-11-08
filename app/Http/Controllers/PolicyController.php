<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Policy;
use App\Models\AuditLog;
use App\Models\PolicyType;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\PolicyRenewal;
use App\Mail\RenewalPolicyEmail;
use App\Models\InsuranceCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StorePolicyRequest;
use App\Http\Requests\UpdatePolicyRequest;

class PolicyController extends Controller {
    public function index(Request $request) {
        $policies = Policy::with(['client', 'company', 'policyType', 'agent'])->paginate(15);
        return view('policies.index', compact('policies'));
    }

    public function create() {
        $clients      = Client::all();
        $companies    = InsuranceCompany::all();
        $agents       = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();

        $policyTypes  = collect();

        return view('policies.forms._policy_form', compact(
            'clients',
            'companies',
            'policyTypes',
            'agents'
        ));
    }

    public function policyTypesByCompany($company_id) {
        $types = PolicyType::whereHas('commissionStructures', function ($q) use ($company_id) {
            $q->where('company_id', $company_id)
                ->where('is_active', true)
                ->where('effective_date', '<=', now())
                ->where(function ($qq) {
                    $qq->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>=', now());
                });
        })->get(['id', 'type_name']);

        return response()->json($types);
    }

    public function store(StorePolicyRequest $request) {

        try {
            $data = $request->validated();

            $typeCode = PolicyType::find($request->policy_type_id)->type_code;

            $data['policy_number']  = $this->generatePolicyNumber($typeCode);

            $policy = Policy::create($data);

            if (!$policy) {
                return redirect()->route('policies.index')->with('error', 'Failed to create policy.');
            }

            DB::statement('CALL CalculateCommission(?, @p_commission_amount, @p_calculation_id)', [$policy->id]);
            $out = DB::select('SELECT @p_commission_amount as commission_amount, @p_calculation_id as calculation_id')[0];

            return redirect()->route('policies.index')->with('success', "Policy created. Commission: {$out->commission_amount}");
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->route('policies.index')->with('error', 'Failed to create policy.');
        }
    }


    function generatePolicyNumber(string $typeCode): string {
        $year = now()->year;
        $prefix = "{$typeCode}-{$year}-";

        // Find the highest counter for this prefix
        $latest = DB::table('policies')
            ->where('policy_number', 'like', $prefix . '%')
            ->selectRaw('MAX(CAST(SUBSTRING(policy_number, -4) AS UNSIGNED)) as counter')
            ->value('counter');

        $counter = ($latest ?? 0) + 1;

        return $prefix . str_pad($counter, 4, '0', STR_PAD_LEFT);
    }


    public function show($id) {
        $policy = Policy::with(['client', 'company', 'policyType', 'agent'])->findOrFail($id);

        // Fetch audit logs (assuming AuditLog model exists with polymorphic relation; adjust as needed)
        $auditLog = AuditLog::where('table_name', 'policies')
            ->where('record_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('policies.forms._policy_details', compact('policy', 'auditLog'));
    }

    public function edit($id) {
        $policy       = Policy::findOrFail($id);
        $clients      = Client::all();
        $companies    = InsuranceCompany::all();
        $agents       = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();

        // Load the policy-types that have a commission structure for the current company
        $policyTypes  = PolicyType::whereHas('commissionStructures', function ($q) use ($policy) {
            $q->where('company_id', $policy->company_id)
                ->where('is_active', true)
                ->where('effective_date', '<=', now())
                ->where(function ($qq) {
                    $qq->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>=', now());
                });
        })->get();

        return view('policies.forms._policy_form', compact(
            'policy',
            'clients',
            'companies',
            'policyTypes',
            'agents'
        ));
    }

    public function update(UpdatePolicyRequest $request, $id) {
        $policy = Policy::findOrFail($id);
        $policy->update($request->validated());
        return redirect()->route('policies.index')->with('success', 'Policy updated successfully.');
    }

    public function destroy($id) {
        $policy = Policy::findOrFail($id);
        $policy->delete();
        return redirect()->route('policies.index')->with('success', 'Policy deleted successfully.');
    }

    // Custom: Expiring report
    public function expiringReport(Request $request) {
        $days = $request->days ?? 30;
        $report = DB::select('CALL GetExpiringPoliciesReport(?)', [$days]);
        return view('policies.expiring-report', compact('report', 'days'));
    }

    // Custom: Update expired
    public function updateExpired() {
        DB::statement('CALL UpdateExpiredPolicies()');
        return redirect()->route('policies.index')->with('success', 'Expired policies updated.');
    }

    public function renew(Request $request, Policy $originalPolicy) {
        $request->validate([
            'new_premium_amount' => 'required|numeric|min:0',
            'renewal_date' => 'required|date',
            'agent_id' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create a new policy record
            $typeCode = $originalPolicy->policyType->type_code;
            $newPolicyNumber = $this->generatePolicyNumber($typeCode);

            $newPolicy = $originalPolicy->replicate();
            $newPolicy->policy_number = $newPolicyNumber;
            $newPolicy->premium_amount = $request->new_premium_amount;
            $newPolicy->issue_date = $request->renewal_date;
            $newPolicy->effective_date = $request->renewal_date;
            $newPolicy->expiry_date = date('Y-m-d', strtotime($request->renewal_date . ' +1 year')); // Assuming annual renewal
            $newPolicy->policy_status = 'ACTIVE';
            $newPolicy->agent_id = $request->agent_id;
            $newPolicy->renewal_notice_sent = false; // Reset renewal notice for the new policy
            $newPolicy->renewal_notice_date = null;
            $newPolicy->cancellation_date = null;
            $newPolicy->cancellation_reason = null;
            $newPolicy->save();

            // 2. Mark the original policy as expired
            $originalPolicy->policy_status = 'EXPIRED';
            $originalPolicy->save();

            // 3. Create a policy renewal record
            $policyRenewal = PolicyRenewal::create([
                'original_policy_id' => $originalPolicy->id,
                'new_policy_id' => $newPolicy->id,
                'renewal_date' => $request->renewal_date,
                'old_premium_amount' => $originalPolicy->premium_amount,
                'new_premium_amount' => $request->new_premium_amount,
                'renewal_status' => 'COMPLETED',
                'agent_id' => $request->agent_id,
                'notes' => 'Policy renewed.',
            ]);

            // 4. Trigger notifications
            $this->sendRenewalNotifications($policyRenewal, $newPolicy);

            DB::commit();

            return redirect()->route('policies.index')->with('success', 'Policy renewed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to renew policy: ' . $e->getMessage());
        }
    }

    private function sendRenewalNotifications(PolicyRenewal $policyRenewal, Policy $newPolicy) {
        // Create internal notification
        Notification::createRenewalNotification($policyRenewal);

        // Send email to client
        $client = $newPolicy->client;
        if ($client && $client->email) {
            Mail::to($client->email)->send(new RenewalPolicyEmail($policyRenewal, $newPolicy));
        }
    }
}
