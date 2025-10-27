<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Http\Requests\StorePolicyRequest;
use App\Http\Requests\UpdatePolicyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PolicyController extends Controller {
    public function index() {
        $policies = Policy::with(['client', 'company', 'policyType', 'agent'])->paginate(15);
        return view('policies.index', compact('policies'));
    }

    public function create() {
        $clients = \App\Models\Client::all();
        $companies = \App\Models\InsuranceCompany::all();
        $policyTypes = \App\Models\PolicyType::all();
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('policies.form', compact('clients', 'companies', 'policyTypes', 'agents'));
    }

    public function store(StorePolicyRequest $request) {
        // Generate policy number via proc
        $companyCode = \App\Models\InsuranceCompany::find($request->company_id)->company_code;
        $typeCode = \App\Models\PolicyType::find($request->policy_type_id)->type_code;
        $policyNumber = DB::select('CALL GeneratePolicyNumber(?, ?, ?)', [$companyCode, $typeCode, ''])[0]->p_policy_number ?? 'POL' . now()->year . '0001';

        $policy = Policy::create($request->validated() + ['policy_number' => $policyNumber]);

        // Call commission calc proc
        $commissionAmount = 0;
        $calculationId = 0;
        DB::statement('CALL CalculateCommission(?, @p_commission_amount, @p_calculation_id)', [$policy->id]);
        $out = DB::select('SELECT @p_commission_amount as commission_amount, @p_calculation_id as calculation_id')[0];

        return redirect()->route('policies.index')->with('success', "Policy created. Commission: {$out->commission_amount}");
    }

    // show, edit, update, destroy similar

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
