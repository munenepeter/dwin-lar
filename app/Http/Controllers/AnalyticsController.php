<?php

namespace App\Http\Controllers\Admin;

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
                ->where('status', 'active')
                ->sum('premium_amount'),
            'total_commissions' => DB::table('commission_calculations')
                ->where('status', 'paid')
                ->sum('commission_amount'),
            'active_policies' => DB::table('policies')
                ->where('status', 'active')
                ->count(),
            'new_clients_this_month' => DB::table('clients')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            // Add more analytics as needed
        ];

        return view('admin.analytics.index', compact('analytics'));
    }
}
