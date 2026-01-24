<?php

namespace App\Http\Requests\Client;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'code' => ['nullable', 'string', 'max:50', Rule::unique('clients', 'code')->ignore($clientId)],

            // Location information
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'timezone_id' => ['nullable', 'exists:timezones,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'nationality_id' => ['nullable', 'exists:nationalities,id'],

            // Personal name information
            'first_name' => ['nullable', 'string', 'max:140'],
            'last_name' => ['nullable', 'string', 'max:140'],

            // Personal details
            'gender' => ['nullable', 'in:male,female'],
            'birth_date' => ['nullable', 'date'],

            // Passport information
            'passport_number' => ['nullable', 'string', 'max:50'],
            'passport_issue_date' => ['nullable', 'date', 'before_or_equal:today'],
            'passport_expiry_date' => ['nullable', 'date', 'after:passport_issue_date'],

            // Email addresses
            'personal_email' => ['nullable', 'email', 'max:255'],
            'email_primary' => ['nullable', 'email', 'max:255', Rule::unique('clients', 'email_primary')->ignore($clientId)],
            'work_email' => ['nullable', 'email', 'max:255'],
            'secondary_email' => ['nullable', 'email', 'max:255'],

            // Phone numbers
            'primary_phone' => ['nullable', 'string', 'max:17'],
            'secondary_phone' => ['nullable', 'string', 'max:17'],
            'mobile' => ['nullable', 'string', 'max:17'],
            'home_phone' => ['nullable', 'string', 'max:17'],
            'work_phone' => ['nullable', 'string', 'max:17'],
            'work_phone_ext' => ['nullable', 'string', 'max:17'],
            'fax_number' => ['nullable', 'string', 'max:17'],
            'whatsapp' => ['nullable', 'string', 'max:17'],

            // Company/Business information
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:17'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:140'],
            'sector' => ['nullable', 'string', 'max:140'],
            'department' => ['nullable', 'string', 'max:140'],
            'business_type' => ['nullable', 'string', 'max:140'],
            'business_registration_number' => ['nullable', 'string', 'max:50'],
            'tax_id' => ['nullable', 'string', 'max:50'],

            // Address information
            'box' => ['nullable', 'string', 'max:50'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'street_address' => ['nullable', 'string', 'max:500'],
            'address_line_2' => ['nullable', 'string', 'max:500'],

            // Online presence
            'website_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],

            // Status and preferences
            'client_status' => ['nullable', 'in:active,inactive,pending,blacklisted'],
            'is_active' => 'nullable|boolean',
            'description' => ['nullable', 'string', 'max:1400'],
            'notes' => ['nullable', 'string', 'max:1400'],
        ];
    }
}
