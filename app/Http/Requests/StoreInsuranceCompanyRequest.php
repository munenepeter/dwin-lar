<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceCompanyRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'company_name' => 'required|string|max:100|unique:insurance_companies',
            'company_code' => 'required|string|max:20|unique:insurance_companies',
            'contact_person' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ];
    }
}
