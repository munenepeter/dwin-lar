<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Policy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CommissionCalculation;


class DashboardController {
    public function __invoke() {
        // 1. Total Number of Clients
        $totalClients = Client::count();

        // 2. Total Number of Active Policies
        $activePolicies = Policy::where('policy_status', 'ACTIVE')->count();

        // 3. Total Premium Amount (Year-to-Date)
        $yearToDatePremium = Policy::whereYear('created_at', now()->year)
            ->sum('premium_amount');

        // 4. Total Commission Earned (Year-to-Date - Paid Commissions)
        $yearToDateCommission = CommissionCalculation::whereYear('created_at', now()->year)
            ->where('payment_status', 'PAID')
            ->sum('commission_amount');

        // 5. Number of Policies Expiring Soon (next 30 days)
        try {
            $expiringPoliciesResult = DB::select('CALL GetExpiringPoliciesReport(?)', [30]);
            $expiringPolicies = $expiringPoliciesResult[0]->count ?? 0;
        } catch (\Exception $e) {
            $expiringPolicies = 0;
            Log::error('Error executing GetExpiringPoliciesReport: ' . $e->getMessage());
        }

        // 6. Policy Distribution by Type
        $policiesByType = DB::table('policies as p')
            ->join('policy_types as pt', 'p.policy_type_id', '=', 'pt.id')
            ->select('pt.type_name', DB::raw('COUNT(p.id) as policy_count'))
            ->groupBy('pt.type_name')
            ->get();

        $policyTypeLabels = $policiesByType->pluck('type_name');
        $policyTypeData = $policiesByType->pluck('policy_count');

        // 7. Policy Distribution by Company
        $policiesByCompany = DB::table('policies as p')
            ->join('insurance_companies as ic', 'p.company_id', '=', 'ic.id')
            ->select('ic.company_name', DB::raw('COUNT(p.id) as policy_count'))
            ->groupBy('ic.company_name')
            ->get();

        $policyCompanyLabels = $policiesByCompany->pluck('company_name');
        $policyCompanyData = $policiesByCompany->pluck('policy_count');

        return view('dashboard', [
            'totalClients' => $totalClients,
            'activePolicies' => $activePolicies,
            'yearToDatePremium' => $yearToDatePremium ?? 0,
            'yearToDateCommission' => $yearToDateCommission ?? 0,
            'expiringPolicies' => $expiringPolicies ?? 0,
            'policyTypeLabels' => $policyTypeLabels->toJson(),
            'policyTypeData' => $policyTypeData->toJson(),
            'policyCompanyLabels' => $policyCompanyLabels->toJson(),
            'policyCompanyData' => $policyCompanyData->toJson(),
        ]);
    }
}
