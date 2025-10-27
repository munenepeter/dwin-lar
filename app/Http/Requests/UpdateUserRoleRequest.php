
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'role_name' => 'required|string|max:50|unique:user_roles,role_name,' . $this->userRole->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'is_active' => 'boolean',
        ];
    }
}
