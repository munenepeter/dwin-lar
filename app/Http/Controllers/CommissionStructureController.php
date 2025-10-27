<?php

namespace App\Http\Controllers;

use App\Models\CommissionStructure;
use App\Http\Requests\StoreCommissionStructureRequest;
use App\Http\Requests\UpdateCommissionStructureRequest;

class CommissionStructureController extends Controller {
    public function index() {
        $commissionStructures = CommissionStructure::with(['company', 'policyType'])->paginate(15);
        return view('commission-structures.index', compact('commissionStructures'));
    }

    public function create() {
        $companies = \App\Models\InsuranceCompany::all();
        $policyTypes = \App\Models\PolicyType::all();
        return view('commission-structures.form', compact('companies', 'policyTypes'));
    }

    public function store(StoreCommissionStructureRequest $request) {
        try {
            CommissionStructure::updateOrCreate($request->validated());
            return redirect()->back()->with('success', 'Commission structure created.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(CommissionStructure $commissionStructure) {
        $commissionStructure->load(['company', 'policyType', 'commissionCalculations']);
        return view('commission-structures.show', compact('commissionStructure'));
    }

    public function edit(CommissionStructure $commissionStructure) {
        $companies = \App\Models\InsuranceCompany::all();
        $policyTypes = \App\Models\PolicyType::all();
        return view('commission-structures.from', compact('commissionStructure', 'companies', 'policyTypes'));
    }

    public function update(UpdateCommissionStructureRequest $request, CommissionStructure $commissionStructure) {
        $commissionStructure->update($request->validated());
        return redirect()->route('commission-structures.index')->with('success', 'Commission structure updated.');
    }

    public function destroy(CommissionStructure $commissionStructure) {
        $commissionStructure->delete();
        return redirect()->route('commission-structures.index')->with('success', 'Commission structure deleted.');
    }
}
