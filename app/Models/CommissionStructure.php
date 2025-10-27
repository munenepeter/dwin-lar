<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommissionStructure extends Model {
    use HasFactory;

    protected $fillable = ['company_id', 'policy_type_id', 'structure_name', 'commission_type', 'base_percentage', 'fixed_amount', 'tier_structure', 'minimum_premium', 'maximum_premium', 'effective_date', 'expiry_date', 'is_active'];
    protected $casts = ['tier_structure' => 'array', 'is_active' => 'boolean', 'effective_date' => 'date', 'expiry_date' => 'date'];

    public function company() {
        return $this->belongsTo(InsuranceCompany::class);
    }

    public function policyType() {
        return $this->belongsTo(PolicyType::class);
    }

    public function commissionCalculations() {
        return $this->hasMany(CommissionCalculation::class);
    }
}
