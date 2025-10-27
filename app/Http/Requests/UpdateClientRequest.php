<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:MALE,FEMALE,OTHER',
            'phone_primary' => 'required|string|max:255',
            'phone_secondary' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'county' => 'nullable|string|max:255',
            'assigned_agent_id' => 'nullable|exists:users,id',
            'client_status' => 'required|in:ACTIVE,INACTIVE,SUSPENDED',
            'notes' => 'nullable|string',
        ];
    }
}
