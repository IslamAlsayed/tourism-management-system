<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $clientId = $this->route('client');

        return [
            'client_code' => ['nullable', 'string', 'max:50', 'unique:clients,client_code,' . $clientId],
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', 'unique:clients,email,' . $clientId],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],

            'region_id' => ['nullable', 'string', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'string', 'exists:subregions,id'],
            'country_id' => ['nullable', 'string', 'exists:countries,id'],

            'state_id' => ['nullable'],
            'state_id.*' => ['integer', 'exists:states,id'],

            'city_id' => ['nullable'],
            'city_id.*' => ['integer', 'exists:cities,id'],
            'nationality_id' => ['nullable', 'integer', 'exists:nationalities,id'],

            'postal_code' => ['nullable', 'string', 'max:20'],

            // Company Information
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'tax_number' => ['nullable', 'string', 'max:50'],
            'commercial_registration' => ['nullable', 'string', 'max:50'],
            'company_phone' => ['nullable', 'string', 'max:20'],
            'company_email' => ['nullable', 'email', 'max:255'],

            // Personal Information
            'passport_number' => ['nullable', 'string', 'max:50'],
            'id_number' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female'],

            // Client Classification
            'client_type' => ['nullable', 'string', 'in:individual,corporate'],
            'client_status' => ['nullable', 'string', 'in:active,inactive,blacklisted'],

            // Financial Information
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'payment_terms' => ['nullable', 'integer', 'min:0'],
            'discount_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'currency' => ['nullable', 'string', 'max:3'],

            // Additional Fields
            'preferred_language' => ['nullable', 'string', 'max:10'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'max:2048', 'mimes:png,jpg,jpeg,gif,svg'],
            'is_active' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
        ];
    }
}