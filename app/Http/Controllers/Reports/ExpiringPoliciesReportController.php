<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpiringPoliciesReportController extends Controller
{
    public function index(Request $request)
    {
        $daysAhead = $request->input('days_ahead', 30);
        $reportData = [];

        try {
            $reportData = DB::select('CALL GetExpiringPoliciesReport(?)', [$daysAhead]);
        } catch (\Exception $e) {
            Log::error('Error executing GetExpiringPoliciesReport: ' . $e->getMessage());
            // Optionally, you can add a friendly error message to the session
            // session()->flash('error', 'There was a problem generating the report.');
        }

        return view('reports.expiring-policies.index', compact('reportData'));
    }
}
