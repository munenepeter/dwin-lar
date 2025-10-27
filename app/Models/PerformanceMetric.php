<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceMetric extends Model {
    use HasFactory;

    protected $fillable = ['commission_payment_id', 'commission_calculation_id'];

    public function payment() {
        return $this->belongsTo(CommissionPayment::class);
    }

    public function calculation() {
        return $this->belongsTo(CommissionCalculation::class);
    }
}
