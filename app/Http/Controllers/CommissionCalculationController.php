<?php

namespace App\Http\Controllers;

use App\Models\CommissionCalculation;
use App\Http\Requests\StoreCommissionCalculationRequest;
use App\Http\Requests\UpdateCommissionCalculationRequest;
use Illuminate\Support\Facades\DB;

class CommissionCalculationController extends Controller {
    public function index() {
        $commissionCalculations = CommissionCalculation::with(['policy', 'agent', 'company'])->paginate(15);
        return view('commission-calculations.index', compact('commissionCalculations'));
    }

    public function create() {
        $policies = \App\Models\Policy::all();
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        $companies = \App\Models\InsuranceCompany::all();
        $commissionStructures = \App\Models\CommissionStructure::all();
        return view('commission-calculations.create', compact('policies', 'agents', 'companies', 'commissionStructures'));
    }

    public function store(StoreCommissionCalculationRequest $request) {
        DB::statement('CALL CalculateCommission(?, @p_commission_amount, @p_calculation_id)', [$request->policy_id]);
        $out = DB::select('SELECT @p_commission_amount as commission_amount, @p_calculation_id as calculation_id')[0];
        return redirect()->route('commission-calculations.index')->with('success', "Commission calculated: {$out->commission_amount}");
    }

    public function show(CommissionCalculation $commissionCalculation) {
        $commissionCalculation->load(['policy', 'agent', 'company', 'commissionStructure']);
        return view('commission-calculations.show', compact('commissionCalculation'));
    }

    public function edit(CommissionCalculation $commissionCalculation) {
        $policies = \App\Models\Policy::all();
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        $companies = \App\Models\InsuranceCompany::all();
        $commissionStructures = \App\Models\CommissionStructure::all();
        return view('commission-calculations.edit', compact('commissionCalculation', 'policies', 'agents', 'companies', 'commissionStructures'));
    }

    public function update(UpdateCommissionCalculationRequest $request, CommissionCalculation $commissionCalculation) {
        $commissionCalculation->update($request->validated());
        return redirect()->route('commission-calculations.index')->with('success', 'Commission calculation updated.');
    }

    public function destroy(CommissionCalculation $commissionCalculation) {
        $commissionCalculation->delete();
        return redirect()->route('commission-calculations.index')->with('success', 'Commission calculation deleted.');
    }

    public function outstandingReport() {
        $report = DB::select('CALL GetOutstandingCommissions()');
        return view('commission-calculations.outstanding-report', compact('report'));
    }
}
