<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PolicyType extends Model {
    use HasFactory;

    protected $fillable = ['type_name', 'type_code', 'description', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function commissionStructures() {
        return $this->hasMany(CommissionStructure::class, 'policy_type_id');
    }

    public function policies() {
        return $this->hasMany(Policy::class, 'policy_type_id');
    }
}
