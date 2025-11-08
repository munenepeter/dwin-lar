<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiringPoliciesReportMail extends Mailable {
    use Queueable, SerializesModels;

    public $pdfPath;
    public $reportData;
    public $daysAhead;

    public function __construct($pdfPath, $reportData, $daysAhead) {
        $this->pdfPath = $pdfPath;
        $this->reportData = $reportData;
        $this->daysAhead = $daysAhead;
    }

    public function build() {
        return $this->subject('Expiring Policies Report')
            ->view('emails.reports.expiring-policies')
            ->with([
                'daysAhead' => $this->daysAhead,
            ])
            ->attach($this->pdfPath, [
                'as' => 'expiring-policies-report.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
