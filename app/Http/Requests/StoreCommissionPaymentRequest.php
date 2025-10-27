<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommissionPaymentRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'payment_batch_number' => 'required|string|max:50|unique:commission_payments',
            'agent_id' => 'required|exists:users,id',
            'payment_period_start' => 'required|date',
            'payment_period_end' => 'required|date|after_or_equal:payment_period_start',
            'total_commission_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => ['required', Rule::in(['BANK_TRANSFER', 'CHEQUE', 'CASH', 'MOBILE_MONEY'])],
            'payment_reference' => 'nullable|string|max:100',
            'bank_details' => 'nullable|json',
            'status' => ['required', Rule::in(['PENDING', 'PROCESSED', 'FAILED', 'CANCELLED'])],
            'notes' => 'nullable|string',
        ];
    }
}
