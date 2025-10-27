<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Http\Requests\StorePolicyRequest;
use App\Http\Requests\UpdatePolicyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\InsuranceCompany;
use App\Models\PolicyType;
use App\Models\User;
use App\Models\AuditLog;

class PolicyController extends Controller {
    public function index(Request $request) {
        $policies = Policy::with(['client', 'company', 'policyType', 'agent'])->paginate(15);
        return view('policies.index', compact('policies'));
    }

    public function create() {
        $clients = Client::all();
        $companies = InsuranceCompany::all();
        $policyTypes = PolicyType::all();
        $agents = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        $policy = null; // For create
        return view('policies.forms._policy_form', compact('clients', 'companies', 'policyTypes', 'agents', 'policy'));
    }

    public function store(StorePolicyRequest $request) {

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
            ->get(); // If no AuditLog model, set to [] or implement query

        return view('policies.forms._policy_details', compact('policy', 'auditLog'));
    }

    public function edit($id) {
        $policy = Policy::findOrFail($id);
        $clients = Client::all();
        $companies = InsuranceCompany::all();
        $policyTypes = PolicyType::all();
        $agents = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('policies.forms._policy_form', compact('clients', 'companies', 'policyTypes', 'agents', 'policy'));
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
}
