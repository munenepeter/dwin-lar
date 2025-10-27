<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PolicyRenewal extends Model {
    use HasFactory;

 protected $fillable = [
 'original_policy_id',
 'new_policy_id',
 'renewal_date',
 'old_premium_amount',
 'new_premium_amount',
 'renewal_status',
 'agent_id',
 'notes',
 ];

 public function originalPolicy() {
 return $this->belongsTo(Policy::class, 'original_policy_id');
 }

 public function newPolicy() {
 return $this->belongsTo(Policy::class, 'new_policy_id');
 }
 public function agent() {
 return $this->belongsTo(User::class, 'agent_id');
 }
    }
}
