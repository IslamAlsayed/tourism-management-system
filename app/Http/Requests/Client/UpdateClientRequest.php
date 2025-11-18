<?php

namespace App\Http\Requests\Client;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            // Location
            'region_id' => 'nullable|exists:regions,id',
            'subregion_id' => 'nullable|exists:subregions,id',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',

            // Personal name
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'gf_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',

            // Personal details
            'gender' => 'nullable|in:male,female,other',
            'nationality' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',

            // Passport
            'passport_number' => 'nullable|string|max:255',
            'passport_issue_date' => 'nullable|date|before_or_equal:today',
            'passport_expiry_date' => 'nullable|date|after:today',

            // Emails
            'personal_email' => 'nullable|email|max:255',
            'email_primary' => ['required', 'email', 'max:255', Rule::unique('clients', 'email_primary')->ignore($this->route('client'))],
            'work_email' => 'nullable|email|max:255',
            'secondary_email' => 'nullable|email|max:255',

            // Phones
            'primary_phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'mobile_phone' => 'nullable|string|max:20',
            'home_phone' => 'nullable|string|max:20',
            'work_phone' => 'nullable|string|max:20',
            'work_phone_ext' => 'nullable|string|max:10',
            'fax_number' => 'nullable|string|max:20',

            // Company
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',

            // Address
            'box' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:500',
            'address_line_2' => 'nullable|string|max:500',

            // Online
            'website_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',

            // Status
            'client_status' => 'nullable|in:active,inactive,pending,blacklisted',
            'timezone' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'region_id' => __('main.region'),
            'subregion_id' => __('main.subregion'),
            'country_id' => __('main.country'),
            'state_id' => __('main.state'),
            'city_id' => __('main.city'),
            'first_name' => __('main.first_name'),
            'middle_name' => __('main.middle_name'),
            'gf_name' => __('main.gf_name'),
            'last_name' => __('main.last_name'),
            'gender' => __('main.gender'),
            'nationality' => __('main.nationality'),
            'birth_date' => __('main.birth_date'),
            'passport_number' => __('main.passport_number'),
            'passport_issue_date' => __('main.passport_issue_date'),
            'passport_expiry_date' => __('main.passport_expiry_date'),
            'personal_email' => __('main.personal_email'),
            'email_primary' => __('main.email_primary'),
            'work_email' => __('main.work_email'),
            'secondary_email' => __('main.secondary_email'),
            'primary_phone' => __('main.primary_phone'),
            'secondary_phone' => __('main.secondary_phone'),
            'mobile_phone' => __('main.mobile_phone'),
            'home_phone' => __('main.home_phone'),
            'work_phone' => __('main.work_phone'),
            'work_phone_ext' => __('main.work_phone_ext'),
            'fax_number' => __('main.fax_number'),
            'company_name' => __('main.company_name'),
            'job_title' => __('main.job_title'),
            'sector' => __('main.sector'),
            'department' => __('main.department'),
            'business_type' => __('main.business_type'),
            'business_registration_number' => __('main.business_registration_number'),
            'tax_id' => __('main.tax_id'),
            'box' => __('main.box'),
            'postal_code' => __('main.postal_code'),
            'street_address' => __('main.street_address'),
            'address_line_2' => __('main.address_line_2'),
            'website_url' => __('main.website_url'),
            'linkedin_url' => __('main.linkedin_url'),
            'client_status' => __('main.status'),
            'timezone' => __('main.timezone'),
            'notes' => __('main.notes'),
        ];
    }
}

