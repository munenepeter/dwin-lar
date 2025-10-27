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
class AnalyticsController extends Controller {
    public function index() {
        // Get analytics data
        $analytics = [
            'total_revenue' => DB::table('policies')
                ->where('policy_status', 'active')
                ->sum('premium_amount'),
            'total_commissions' => DB::table('commission_calculations')
                ->sum('commission_amount'),
            'active_policies' => DB::table('policies')
                ->where('policy_status', 'active')
                ->count(),
            'new_clients_this_month' => DB::table('clients')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            // Add more analytics as needed
        ];

        return view('analytics.index', compact('analytics'));
    }
}
