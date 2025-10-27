<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommissionStructureRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'company_id'        => 'required|exists:insurance_companies,id',
            'policy_type_id'    => 'required|exists:policy_types,id',
            'structure_name'    => 'required|string|max:100',
            'commission_type'   => 'required|in:FLAT_PERCENTAGE,TIERED,FIXED_AMOUNT',
            'base_percentage'   => 'nullable|numeric|between:0,100|required_if:commission_type,FLAT_PERCENTAGE',
            'fixed_amount'      => 'nullable|numeric|min:0|required_if:commission_type,FIXED_AMOUNT',
            'tier_structure'    => 'nullable|json|required_if:commission_type,TIERED',
            'minimum_premium'   => 'required|numeric|min:0',
            'maximum_premium'   => 'nullable|numeric|gte:minimum_premium',
            'effective_date'    => 'required|date',
            'expiry_date'       => 'nullable|date|after:effective_date',
            'is_active'         => 'required|boolean',
        ];
    }
}
