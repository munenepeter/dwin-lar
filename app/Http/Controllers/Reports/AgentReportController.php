<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentReportController extends Controller
{
    public function index(Request $request)
    {
        $agents = User::whereHas('role', function ($query) {
            $query->where('role_name', 'Agent');
        })->get();

        $reportData = null;

        if ($request->filled('agent_id') && $request->filled('start_date') && $request->filled('end_date')) {
            $reportData = DB::select(
                'CALL GetAgentPerformanceReport(?, ?, ?)',
                [$request->input('agent_id'), $request->input('start_date'), $request->input('end_date')]
            );
        }

        return view('reports.agent-reports.index', compact('agents', 'reportData'));
    }
}
