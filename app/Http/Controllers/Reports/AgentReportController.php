<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgentPerformanceReportMail; // Assuming you'll create this Mailable

class AgentReportController extends Controller {
    public function index(Request $request) {
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

        // Check for PDF export
        if ($request->has('format') && $request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.agent-reports.pdf', compact('agents', 'reportData', 'request'));
            return $pdf->download('agent-performance-report.pdf');
        }

        // Check for email action (assuming email is provided in request, e.g., ?action=email&to=example@email.com)
        if ($request->has('action') && $request->action === 'email' && $request->filled('to')) {
            $agent = $agents->find($request->input('agent_id'));
            $agentName = $agent ? $agent->full_name : 'Unknown';
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $pdf = Pdf::loadView('reports.agent-reports.pdf', compact('agents', 'reportData', 'request'));
            $pdfPath = storage_path('app/public/agent-performance-report.pdf');
            $pdf->save($pdfPath);

            Mail::to($request->to)->send(new AgentPerformanceReportMail($pdfPath, $reportData, $agentName, $startDate, $endDate));

            // Clean up the temporary PDF file
            unlink($pdfPath);

            return response()->json(['success' => true, 'message' => 'Report sent via email successfully.']);
        }

        return view('reports.agent-reports.index', compact('agents', 'reportData'));
    }
}
