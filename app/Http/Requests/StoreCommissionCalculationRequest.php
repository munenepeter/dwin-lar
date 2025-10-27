<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommissionCalculationRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'policy_id' => 'required|exists:policies,id',
        ];
    }
}
