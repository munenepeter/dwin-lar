<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model {
    use HasFactory;

    protected $fillable = ['client_code', 'first_name', 'last_name', 'id_number', 'date_of_birth', 'gender', 'email', 'phone_primary', 'phone_secondary', 'address', 'city', 'county', 'country', 'occupation', 'employer', 'annual_income', 'marital_status', 'next_of_kin', 'next_of_kin_phone', 'next_of_kin_relationship', 'assigned_agent_id', 'client_status', 'kyc_status', 'kyc_verified_date', 'notes'];
    protected $casts = ['date_of_birth' => 'date', 'annual_income' => 'decimal:2', 'kyc_verified_date' => 'datetime'];

    public function assignedAgent() {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function documents() {
        return $this->hasMany(ClientDocument::class);
    }

    public function policies() {
        return $this->hasMany(Policy::class);
    }
}
