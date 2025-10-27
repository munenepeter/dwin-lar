<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * AnalyticsController
 * Handles analytics and insights dashboard
 */
class AnalyticsController extends Controller
{
    public function index()
    {
        // General Metrics
        $totalClients = DB::table('clients')->count();
        $totalPolicies = DB::table('policies')->count();
        $totalPremium = DB::table('policies')->sum('premium_amount');
        $totalCommissions = DB::table('commission_calculations')->sum('commission_amount');
        // Client Analytics
        $clientAcquisition = DB::table('clients')
            ->select(DB::raw('DATE_FORMAT(created_at, \'%Y-%m\') as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        $clientStatus = DB::table('clients')
            ->select('client_status', DB::raw('count(*) as total'))
            ->groupBy('client_status')
            ->get();
        // Policy Analytics
        $policiesSold = DB::table('policies')
            ->select(DB::raw('DATE_FORMAT(created_at, \'%Y-%m\') as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        $premiumGrowth = DB::table('policies')
            ->select(DB::raw('DATE_FORMAT(created_at, \'%Y-%m\') as month'), DB::raw('sum(premium_amount) as total'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        $policyStatusDistribution = DB::table('policies')
            ->select('policy_status', DB::raw('count(*) as total'))
            ->groupBy('policy_status')
            ->get();
        $expiringPolicies = DB::table('policies')
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays(90))
            ->count();
        // Commission Analytics
        $commissionsEarned = DB::table('commission_calculations')
            ->select(DB::raw('DATE_FORMAT(calculation_date, \'%Y-%m\') as month'), DB::raw('sum(commission_amount) as total'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        $topAgents = DB::table('users')
            ->join('policies', 'users.id', '=', 'policies.agent_id')
            ->select('users.full_name', DB::raw('count(policies.id) as total_policies'), DB::raw('sum(policies.premium_amount) as total_premium'))
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('total_policies', 'desc')
            ->limit(10)
            ->get();
        $commissionsByCompany = DB::table('insurance_companies')
            ->join('commission_calculations', 'insurance_companies.id', '=', 'commission_calculations.company_id')
            ->select('insurance_companies.company_name', DB::raw('sum(commission_calculations.commission_amount) as total_commission'))
            ->groupBy('insurance_companies.id', 'insurance_companies.company_name')
            ->orderBy('total_commission', 'desc')
            ->get();
            
        return view('analytics.index', compact(
            'totalClients', 'totalPolicies', 'totalPremium', 'totalCommissions',
            'clientAcquisition', 'clientStatus', 'policiesSold', 'premiumGrowth',
            'policyStatusDistribution', 'expiringPolicies', 'commissionsEarned',
            'topAgents', 'commissionsByCompany'
        ));
    }
}
