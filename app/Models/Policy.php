<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model {
    use HasFactory;

    protected $table = 'policies';

    protected $fillable = [
        'policy_number',
        'client_id',
        'company_id',
        'policy_type_id',
        'agent_id',
        'policy_status',
        'premium_amount',
        'sum_insured',
        'coverage_details',
        'issue_date',
        'effective_date',
        'expiry_date',
        'payment_frequency',
        'payment_method',
        'renewal_notice_sent',
        'renewal_notice_date',
        'cancellation_date',
        'cancellation_reason',
        'notes',
    ];

    protected $casts = [
        'coverage_details' => 'array',
        'issue_date' => 'date',
        'effective_date' => 'date',
        'expiry_date' => 'date',
        'renewal_notice_sent' => 'boolean',
        'renewal_notice_date' => 'datetime',
        'cancellation_date' => 'date',
    ];


    /**
     * The client who owns the policy.
     */
    public function client() {
        return $this->belongsTo(Client::class);
    }

    /**
     * The insurance company that issued the policy.
     */
    public function company() {
        return $this->belongsTo(InsuranceCompany::class);
    }

    /**
     * The policy type (e.g., life, vehicle, health).
     */
    public function policyType() {
        return $this->belongsTo(PolicyType::class);
    }

    /**
     * The agent (user) who handled the policy.
     */
    public function agent() {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
