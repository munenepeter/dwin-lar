<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\OutstandingCommissionsReportMail;

class FinancialReportController extends Controller {
    public function index(Request $request) {
        $reportData = DB::select('CALL GetOutstandingCommissions()');

        // Check for PDF export
        if ($request->has('format') && $request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.financial-reports.pdf', compact('reportData'));
            return $pdf->download('outstanding-commissions-report.pdf');
        }

        if ($request->has('action') && $request->action === 'email' && $request->filled('to')) {
            $pdf = Pdf::loadView('reports.financial-reports.pdf', compact('reportData'));
            $pdfPath = storage_path('app/public/outstanding-commissions-report.pdf');
            $pdf->save($pdfPath);

            Mail::to($request->to)->send(new OutstandingCommissionsReportMail($pdfPath, $reportData));

            // Clean up the temporary PDF file
            unlink($pdfPath);

            return response()->json(['success' => true, 'message' => 'Report sent via email successfully.']);
        }

        return view('reports.financial-reports.index', compact('reportData'));
    }
}
