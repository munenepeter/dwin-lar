<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PolicyRenewal;

class Notification extends Model
{
   use HasFactory;

    protected $fillable = [
        'notification_type',
        'title',
        'message',
        'target_user_id',
        'target_role_id',
        'related_table',
        'related_record_id',
        'priority',
        'is_read',
        'is_sent',
        'send_email',
        'send_sms',
    ];

    public function payment() // Rename to commissionPayment
    {
        return $this->belongsTo(CommissionPayment::class);
    }

    public function calculation()
    {
        return $this->belongsTo(CommissionCalculation::class);
    }

    public static function createRenewalNotification(PolicyRenewal $policyRenewal)
    {
        Notification::create([
            'notification_type' => 'RENEWAL_DUE',
            'title' => 'Policy Renewal Notification',
            'message' => "Policy {$policyRenewal->originalPolicy->policy_number} has been renewed as {$policyRenewal->newPolicy->policy_number} on {$policyRenewal->renewal_date}.",
            'target_user_id' => $policyRenewal->agent_id,
            'related_table' => 'policy_renewals',
            'related_record_id' => $policyRenewal->id,
            'priority' => 'HIGH',
            'send_email' => true,
            'send_sms' => true,
        ]);
    }

}
