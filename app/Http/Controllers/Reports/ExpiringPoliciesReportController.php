<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpiringPoliciesReportMail;

class ExpiringPoliciesReportController extends Controller {
    public function index(Request $request) {
        $daysAhead = $request->input('days_ahead', 30);
        $reportData = [];

        try {
            $reportData = DB::select('CALL GetExpiringPoliciesReport(?)', [$daysAhead]);
        } catch (\Exception $e) {
            Log::error('Error executing GetExpiringPoliciesReport: ' . $e->getMessage());
            session()->flash('error', 'There was a problem generating the report.');
        }

        if ($request->has('format') && $request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.expiring-policies.pdf', compact('reportData', 'daysAhead'));
            return $pdf->download('expiring-policies-report.pdf');
        }

        if ($request->has('action') && $request->action === 'email' && $request->filled('to')) {
            $pdf = Pdf::loadView('reports.expiring-policies.pdf', compact('reportData', 'daysAhead'));
            $pdfPath = storage_path('app/public/expiring-policies-report.pdf');
            $pdf->save($pdfPath);

            Mail::to($request->to)->send(new ExpiringPoliciesReportMail($pdfPath, $reportData, $daysAhead));

            unlink($pdfPath);

            return response()->json(['success' => true, 'message' => 'Report sent via email successfully.']);
        }

        return view('reports.expiring-policies.index', compact('reportData'));
    }
}
