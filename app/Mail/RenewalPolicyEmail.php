<?php

namespace App\Mail;

use App\Models\Policy;
use App\Models\PolicyRenewal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RenewalPolicyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public PolicyRenewal $policyRenewal;
    public Policy $newPolicy;

    /**
     * Create a new message instance.
     */
    public function __construct(PolicyRenewal $policyRenewal, Policy $newPolicy)
    {
        $this->policyRenewal = $policyRenewal;
        $this->newPolicy = $newPolicy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Policy Renewal Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.renewal_policy',
            with: [
                'policyRenewal' => $this->policyRenewal,
                'newPolicy' => $this->newPolicy,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
