<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePolicyRenewalRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'original_policy_id' => 'required|exists:policies,id',
            'new_policy_id' => 'nullable|exists:policies,id',
            'renewal_date' => 'required|date',
            'old_premium_amount' => 'required|numeric|min:0',
            'new_premium_amount' => 'required|numeric|min:0',
            'renewal_status' => ['required', Rule::in(['PENDING', 'COMPLETED', 'DECLINED', 'LAPSED'])],
            'agent_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ];
    }
}
