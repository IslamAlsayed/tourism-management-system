<?php

namespace App\Http\Requests\Client;

use Illuminate\Validation\Rule;
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
            'client_code' => ['nullable', 'string', 'max:50', Rule::unique('clients', 'client_code')->ignore($clientId)],

            // Location information
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable'],
            'state_id.*' => ['exists:states,id'],
            'city_id' => ['nullable'],
            'city_id.*' => ['exists:cities,id'],
            'nationality_id' => ['nullable', 'exists:nationalities,id'],
            'currency' => ['nullable', 'string', 'max:3'],

            // Personal name information
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],

            // Personal details
            'gender' => ['nullable', 'in:male,female'],
            'birth_date' => ['nullable', 'date'],

            // Passport information
            'passport_number' => ['nullable', 'string', 'max:50'],
            'passport_issue_date' => ['nullable', 'date', 'before_or_equal:today'],
            'passport_expiry_date' => ['nullable', 'date', 'after:passport_issue_date'],

            // Email addresses
            'personal_email' => ['nullable', 'email', 'max:255'],
            'email_primary' => ['required', 'email', 'max:255', 'unique:clients,email_primary,' . $clientId],
            'work_email' => ['nullable', 'email', 'max:255'],
            'secondary_email' => ['nullable', 'email', 'max:255'],

            // Phone numbers
            'primary_phone' => ['required', 'string', 'max:20'],
            'secondary_phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'home_phone' => ['nullable', 'string', 'max:20'],
            'work_phone' => ['nullable', 'string', 'max:20'],
            'work_phone_ext' => ['nullable', 'string', 'max:10'],
            'fax_number' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],

            // Company/Business information
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:20'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:100'],
            'sector' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'business_type' => ['nullable', 'string', 'max:100'],
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
            'status' => ['nullable', 'in:active,inactive,pending,blacklisted'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    // public function attributes(): array
    // {
    //     return [
    //         'region_id' => __('main.region'),
    //         'subregion_id' => __('main.subregion'),
    //         'country_id' => __('main.country'),
    //         'state_id' => __('main.state'),
    //         'city_id' => __('main.city'),
    //         'nationality_id' => __('main.nationality'),
    //         'currency' => __('main.currency'),
    //         'first_name' => __('main.first_name'),
    //         'middle_name' => __('main.middle_name'),
    //         'gf_name' => __('main.gf_name'),
    //         'last_name' => __('main.last_name'),
    //         'gender' => __('main.gender'),
    //         'birth_date' => __('main.birth_date'),
    //         'passport_number' => __('main.passport_number'),
    //         'passport_issue_date' => __('main.passport_issue_date'),
    //         'passport_expiry_date' => __('main.passport_expiry_date'),
    //         'personal_email' => __('main.personal_email'),
    //         'email_primary' => __('main.email_primary'),
    //         'work_email' => __('main.work_email'),
    //         'secondary_email' => __('main.secondary_email'),
    //         'primary_phone' => __('main.primary_phone'),
    //         'secondary_phone' => __('main.secondary_phone'),
    //         'mobile' => __('main.mobile_phone'),
    //         'home_phone' => __('main.home_phone'),
    //         'work_phone' => __('main.work_phone'),
    //         'work_phone_ext' => __('main.work_phone_ext'),
    //         'fax_number' => __('main.fax_number'),
    //         'whatsapp' => __('main.whatsapp'),
    //         'company_name' => __('main.company_name'),
    //         'company_phone' => __('main.company_phone'),
    //         'company_email' => __('main.company_email'),
    //         'job_title' => __('main.job_title'),
    //         'sector' => __('main.sector'),
    //         'department' => __('main.department'),
    //         'business_type' => __('main.business_type'),
    //         'business_registration_number' => __('main.business_registration_number'),
    //         'tax_id' => __('main.tax_id'),
    //         'box' => __('main.box'),
    //         'postal_code' => __('main.postal_code'),
    //         'street_address' => __('main.street_address'),
    //         'address_line_2' => __('main.address_line_2'),
    //         'website_url' => __('main.website_url'),
    //         'linkedin_url' => __('main.linkedin_url'),
    //         'status' => __('main.status'),
    //         'timezone' => __('main.timezone'),
    //         'notes' => __('main.notes'),
    //     ];
    // }
}