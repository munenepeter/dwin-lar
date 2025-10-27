<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function authorize() {
        return true; // Or auth check
    }

    public function rules() {
        return [
            'username' => 'required|string|unique:users|max:50',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|string|min:8', // Hash in controller
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:user_roles,id',
            'employee_id' => 'nullable|string|unique:users|max:20',
            'is_active' => 'boolean',
        ];
    }
}
