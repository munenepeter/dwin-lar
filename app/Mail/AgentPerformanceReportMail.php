<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgentPerformanceReportMail extends Mailable {
    use Queueable, SerializesModels;

    public $pdfPath;
    public $reportData;
    public $agentName;
    public $startDate;
    public $endDate;

    public function __construct($pdfPath, $reportData, $agentName, $startDate, $endDate) {
        $this->pdfPath = $pdfPath;
        $this->reportData = $reportData;
        $this->agentName = $agentName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build() {
        return $this->subject('Agent Performance Report')
            ->markdown('emails.reports.agent-performance')
            ->with([
                'agentName' => $this->agentName,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
            ])
            ->attach($this->pdfPath, [
                'as' => 'agent-performance-report.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
