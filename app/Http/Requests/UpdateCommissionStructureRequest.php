<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommissionStructureRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'company_id' => 'required|exists:insurance_companies,id',
            'policy_type_id' => 'required|exists:policy_types,id',
            'structure_name' => 'required|string|max:100',
            'commission_type' => ['required', Rule::in(['FLAT_PERCENTAGE', 'TIERED', 'FIXED_AMOUNT'])],
            'base_percentage' => 'nullable|numeric|min:0|max:100',
            'fixed_amount' => 'nullable|numeric|min:0',
            'tier_structure' => 'nullable|json',
            'minimum_premium' => 'nullable|numeric|min:0',
            'maximum_premium' => 'nullable|numeric|min:0',
            'effective_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'is_active' => 'boolean',
        ];
    }
}
