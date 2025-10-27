<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    public function index()
    {
        $reportData = DB::select('CALL GetOutstandingCommissions()');

        return view('reports.financial-reports.index', compact('reportData'));
    }
}
