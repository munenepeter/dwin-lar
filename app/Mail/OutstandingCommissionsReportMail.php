<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OutstandingCommissionsReportMail extends Mailable {
    use Queueable, SerializesModels;

    public $pdfPath;
    public $reportData;

    public function __construct($pdfPath, $reportData) {
        $this->pdfPath = $pdfPath;
        $this->reportData = $reportData;
    }

    public function build() {
        return $this->subject('Outstanding Commissions Report')
            ->view('emails.reports.outstanding-commissions')
            ->attach($this->pdfPath, [
                'as' => 'outstanding-commissions-report.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
