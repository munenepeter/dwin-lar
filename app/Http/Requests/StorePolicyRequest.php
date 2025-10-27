<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePolicyRequest extends FormRequest {
    public function rules() {
        return [
            'client_id' => 'required|exists:clients,id',
            'company_id' => 'required|exists:insurance_companies,id',
            'policy_type_id' => 'required|exists:policy_types,id',
            'agent_id' => 'required|exists:users,id',
            'policy_status' => [Rule::enum(['ACTIVE', 'EXPIRED', 'CANCELLED', 'SUSPENDED', 'PENDING'])],
            'premium_amount' => 'required|numeric|min:0',
            'sum_insured' => 'required|numeric|min:0',
            'coverage_details' => 'nullable|json',
            'issue_date' => 'required|date',
            'effective_date' => 'required|date',
            'expiry_date' => 'required|date|after:effective_date',
            'payment_frequency' => [Rule::enum(['MONTHLY', 'QUARTERLY', 'SEMI_ANNUAL', 'ANNUAL'])],
            'payment_method' => [Rule::enum(['CASH', 'CHEQUE', 'BANK_TRANSFER', 'MOBILE_MONEY', 'CARD'])],
            // ... other fields
        ];
    }
}
