<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePolicyTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_name' => 'required|string|max:50|unique:policy_types,type_name,' . $this->policyType->id,
            'type_code' => 'required|string|max:20|unique:policy_types,type_code,' . $this->policyType->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}