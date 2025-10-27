<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientDocumentRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'client_id' => 'required|exists:clients,id',
            'document_type' => ['required', Rule::in(['ID_COPY', 'PASSPORT_COPY', 'KRA_PIN', 'PROOF_OF_INCOME', 'BANK_STATEMENT', 'OTHER'])],
            'document_name' => 'required|string|max:255',
            'file_path' => 'required|string|max:500',
            'file_size' => 'nullable|integer',
            'mime_type' => 'nullable|string|max:100',
            'is_verified' => 'boolean',
        ];
    }
}
