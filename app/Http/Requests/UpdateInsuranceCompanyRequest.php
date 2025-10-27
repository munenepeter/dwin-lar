<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInsuranceCompanyRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        $companyId = $this->route('insurance_company')?->id;

        return [
            'company_name' => 'required|string|max:100|unique:insurance_companies,company_name,' . $companyId,
            'company_code' => 'required|string|max:20|unique:insurance_companies,company_code,' . $companyId,
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
