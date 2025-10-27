<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePolicyRequest extends FormRequest {
    public function rules() {
        return [
            'policy_number' => ['nullable', 'string', 'max:50', 'unique:policies,policy_number'],
            'client_id' => ['required', 'exists:clients,id'],
            'company_id' => ['required', 'exists:insurance_companies,id'],
            'policy_type_id' => ['required', 'exists:policy_types,id'],
            'agent_id' => ['required', 'exists:users,id'],

            'policy_status' => ['required', 'string', Rule::in(['ACTIVE', 'EXPIRED', 'CANCELLED', 'SUSPENDED', 'PENDING'])],
            'premium_amount' => ['required', 'numeric', 'min:0'],
            'sum_insured' => ['required', 'numeric', 'min:0'],
            'coverage_details' => ['nullable', 'json'],

            'issue_date' => ['required', 'date'],
            'effective_date' => ['required', 'date'],
            'expiry_date' => ['required', 'date', 'after:effective_date'],

            'payment_frequency' => ['required', 'string', Rule::in(['MONTHLY', 'QUARTERLY', 'SEMI_ANNUAL', 'ANNUAL'])],
            'payment_method' => ['required', 'string', Rule::in(['CASH', 'CHEQUE', 'BANK_TRANSFER', 'MOBILE_MONEY', 'CARD'])],

            'renewal_notice_sent' => ['boolean'],
            'renewal_notice_date' => ['nullable', 'date'],
            'cancellation_date' => ['nullable', 'date'],
            'cancellation_reason' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
