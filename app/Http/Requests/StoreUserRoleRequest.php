<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRoleRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'role_name' => 'required|string|max:50|unique:user_roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'is_active' => 'boolean',
        ];
    }
}
