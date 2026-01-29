<?php

namespace App\Http\Requests\VisaRequirement;

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
        return [
            // Required Fields
            'nationality_id' => ['nullable', 'exists:nationalities,id'],
            'destination_country_id' => ['nullable', 'exists:countries,id'],
            'visa_type' => ['nullable', 'string', 'in:none_required,on_arrival,e_visa,embassy_required,transit,restricted'],
            'visa_category' => ['nullable', 'string', 'in:tourist,business,medical,student,work,transit'],

            // Optional - Crossing Port
            'crossing_port_id' => ['nullable', 'exists:crossing_ports,id'],

            // Restrictions
            'is_restricted' => ['nullable', 'boolean'],
            'can_issue_at_port' => ['nullable', 'boolean'],

            // Stay & Validity
            'max_stay_days' => ['nullable', 'integer', 'min:0'],
            'visa_validity_days' => ['nullable', 'integer', 'min:0'],

            // Fees
            'visa_fee' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'visa_fee_currency_id' => ['nullable', 'exists:currencies,id'],
            'departure_tax' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'departure_tax_currency_id' => ['nullable', 'exists:currencies,id'],

            // Processing
            'processing_time_days' => ['nullable', 'integer', 'min:0'],

            // Group Settings
            'group_min_size' => ['nullable', 'integer', 'min:0'],
            'group_min_nights' => ['nullable', 'integer', 'min:0'],
            'group_processing_days' => ['nullable', 'integer', 'min:0'],

            // URLs
            'application_url' => ['nullable', 'url', 'max:500'],
            'official_source_url' => ['nullable', 'url', 'max:500'],

            // Validity Period
            'effective_from' => ['nullable', 'date'],
            'effective_until' => ['nullable', 'date', 'after_or_equal:effective_from'],

            // Status
            'is_active' => ['nullable', 'boolean'],

            // Content
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
