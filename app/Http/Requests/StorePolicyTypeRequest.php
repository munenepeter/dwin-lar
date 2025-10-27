<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePolicyTypeRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'type_name' => 'required|string|max:50|unique:policy_types',
            'type_code' => 'required|string|max:20|unique:policy_types',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}
