<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'email', 'password', 'first_name', 'last_name', 'phone', 'role_id', 'employee_id', 'is_active', 'last_login', 'password_reset_token', 'password_reset_expires'];
    protected $casts = ['is_active' => 'boolean', 'last_login' => 'datetime', 'password_reset_expires' => 'datetime'];
    protected $hidden = ['password', 'password_reset_token'];


    /**
     * Get the user's initials
     */
    public function initials(): string {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }


    public function role() {
        return $this->belongsTo(UserRole::class);
    }

    public function clients() {
        return $this->hasMany(Client::class, 'assigned_agent_id');
    }

    public function policies() {
        return $this->hasMany(Policy::class, 'agent_id');
    }
}
