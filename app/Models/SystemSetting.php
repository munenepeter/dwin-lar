<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemSetting extends Model {
    use HasFactory;

    protected $fillable = ['setting_key', 'setting_value', 'setting_type', 'description', 'is_system_setting'];
    protected $casts = ['is_system_setting' => 'boolean'];
}
