<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model {
    use HasFactory;

    protected $fillable = ['role_name', 'description', 'permissions', 'is_active'];
    protected $casts = ['permissions' => 'array', 'is_active' => 'boolean'];

    public function users() {
        return $this->hasMany(User::class, 'role_id');
    }
}
