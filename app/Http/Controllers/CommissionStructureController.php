<?php

namespace App\Http\Controllers;

use App\Models\CommissionStructure;
use App\Http\Requests\StoreCommissionStructureRequest;
use App\Http\Requests\UpdateCommissionStructureRequest;
use App\Models\InsuranceCompany;
use App\Models\PolicyType;

class CommissionStructureController extends Controller {
    public function index() {
        $commissionStructures = CommissionStructure::with(['insuranceCompany', 'policyType'])->paginate(15);
        return view('commission-structures.index', compact('commissionStructures'));
    }

    public function create() {
        $companies = InsuranceCompany::all();
        $policyTypes = PolicyType::all();
        return view('commission-structures.form', compact('companies', 'policyTypes'));
    }

    public function store(StoreCommissionStructureRequest $request) {
        CommissionStructure::create($request->validated());
        return redirect()->route('commission-structures.index')->with('success', 'Commission structure created.');
    }

    public function show(CommissionStructure $commissionStructure) {
        $commissionStructure->load(['insuranceCompany', 'policyType']);
        return view('commission-structures.show', compact('commissionStructure'));
    }

    public function edit(CommissionStructure $commissionStructure) {
        $companies = InsuranceCompany::all();
        $policyTypes = PolicyType::all();
        return view('commission-structures.form', compact('commissionStructure', 'companies', 'policyTypes'));
    }

    public function update(UpdateCommissionStructureRequest $request, CommissionStructure $commissionStructure) {
        $commissionStructure->update($request->validated());
        return redirect()->route('commission-structures.index')->with('success', 'Commission structure updated.');
    }

    public function destroy(CommissionStructure $commissionStructure) {
        $commissionStructure->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Commission structure deleted successfully.']);
        }
        return redirect()->route('commission-structures.index')->with('success', 'Commission structure deleted.');
    }
}
