<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceCompany extends Model {
    use HasFactory;

    protected $fillable = ['company_name', 'company_code', 'contact_person', 'email', 'phone', 'city', 'postal_code', 'country', 'website', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function commissionStructures() {
        return $this->hasMany(CommissionStructure::class, 'company_id');
    }

    public function policies() {
        return $this->hasMany(Policy::class, 'company_id');
    }
}
