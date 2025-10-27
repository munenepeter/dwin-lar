<?php

namespace App\Http\Controllers;

use App\Models\InsuranceCompany;
use App\Http\Requests\StoreInsuranceCompanyRequest;
use App\Http\Requests\UpdateInsuranceCompanyRequest;

class InsuranceCompanyController extends Controller {
    public function index() {
        $insuranceCompanies = InsuranceCompany::paginate(15);
        return view('insurance-companies.index', compact('insuranceCompanies'));
    }

    public function create() {
        return view('insurance-companies.create');
    }

    public function store(StoreInsuranceCompanyRequest $request) {
        InsuranceCompany::create($request->validated());
        return redirect()->route('insurance-companies.index')->with('success', 'Insurance company created.');
    }

    public function show(InsuranceCompany $insuranceCompany) {
        $insuranceCompany->load(['commissionStructures', 'policies']);
        return view('insurance-companies.show', compact('insuranceCompany'));
    }

    public function edit(InsuranceCompany $insuranceCompany) {
        return view('insurance-companies.edit', compact('insuranceCompany'));
    }

    public function update(UpdateInsuranceCompanyRequest $request, InsuranceCompany $insuranceCompany) {
        $insuranceCompany->update($request->validated());
        return redirect()->route('insurance-companies.index')->with('success', 'Insurance company updated.');
    }

    public function destroy(InsuranceCompany $insuranceCompany) {
        $insuranceCompany->delete();
        return redirect()->route('insurance-companies.index')->with('success', 'Insurance company deleted.');
    }
}
