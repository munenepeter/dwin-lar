<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommissionPayment extends Model {
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'agent_id',
        'company_id',
        'commission_structure_id',
        'calculation_date',
        'premium_amount',
        'commission_rate',
        'commission_amount',
        'calculation_method',
        'calculation_details',
        'payment_status',
        'payment_date',
        'payment_reference',
        'notes'
    ];
    protected $casts = ['calculation_date' => 'date', 'premium_amount' => 'decimal:2', 'commission_rate' => 'decimal:2', 'commission_amount' => 'decimal:2', 'calculation_details' => 'array', 'payment_date' => 'date'];

    public function policy() {
        return $this->belongsTo(Policy::class);
    }

    public function agent() {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function company() {
        return $this->belongsTo(InsuranceCompany::class);
    }

    public function commissionStructure() {
        return $this->belongsTo(CommissionStructure::class);
    }

    public function paymentItems() {
        return $this->hasMany(CommissionPaymentItem::class, 'commission_calculation_id');
    }
}
