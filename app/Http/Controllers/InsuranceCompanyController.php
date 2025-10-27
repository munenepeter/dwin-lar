<?php

namespace App\Http\Controllers;

use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Http\Requests\StoreInsuranceCompanyRequest;
use App\Http\Requests\UpdateInsuranceCompanyRequest;
use Illuminate\Support\Facades\DB;

class InsuranceCompanyController extends Controller {
    public function index() {
        $insuranceCompanies = InsuranceCompany::with([
            'commissionStructures.policyType' => function ($query) {
                $query->select('id', 'type_name');
            },
        ])->paginate(4);

        $total_companies = InsuranceCompany::count();
        $active_companies = InsuranceCompany::where('is_active', true)->count();
        $total_policies = Policy::count();
        $total_premium = Policy::sum('premium_amount');

        $monthly_policies = Policy::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        $company_stats = InsuranceCompany::select('company_name')
            ->withSum('policies', 'premium_amount')
            ->get()
            ->map(function ($company) {
                return [
                    'company_name' => $company->company_name,
                    'total_premium' => $company->policies_sum_premium ?? 0,
                ];
            });

        return view('insurance-companies.index', compact(
            'insuranceCompanies',
            'total_companies',
            'active_companies',
            'total_policies',
            'total_premium',
            'monthly_policies',
            'company_stats'
        ));
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

    public function stats() {
        return response()->json([
            'total_companies' => InsuranceCompany::count(),
            'active_companies' => InsuranceCompany::where('is_active', true)->count(),
            'total_policies' => Policy::count(),
            'total_premium' => Policy::sum('premium'),
        ]);
    }
}
