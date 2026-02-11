<?php

namespace Modules\TravelDocuments\Http\Requests\TravelPasse;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'country_id' => ['required', 'exists:countries,id'],
            'currency_id' => ['required', 'exists:currencies,id'],

            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],

            'pass_type' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'validity_days' => ['required', 'integer', 'min:1'],

            'special_attraction_days' => ['nullable', 'integer', 'min:0'],
            'waives_visa_fee' => ['nullable', 'boolean'],
            'min_stay_nights' => ['nullable', 'integer', 'min:0'],
            'must_purchase_before_arrival' => ['nullable', 'boolean'],
            'official_purchase_url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],

            'sites' => ['nullable', 'array'],
            'sites.*' => ['exists:tourist_sites,id'],
        ];
    }
}
