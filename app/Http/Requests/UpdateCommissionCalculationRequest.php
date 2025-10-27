#### UpdateCommissionCalculationRequest
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommissionCalculationRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'policy_id' => 'required|exists:policies,id',
            'agent_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:insurance_companies,id',
            'commission_structure_id' => 'required|exists:commission_structures,id',
            'calculation_date' => 'required|date',
            'premium_amount' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0',
            'commission_amount' => 'required|numeric|min:0',
            'calculation_method' => ['required', Rule::in(['FLAT_PERCENTAGE', 'TIERED', 'FIXED_AMOUNT'])],
            'calculation_details' => 'nullable|json',
            'payment_status' => ['required', Rule::in(['PENDING', 'PAID', 'CANCELLED'])],
            'payment_date' => 'nullable|date',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ];
    }
}
