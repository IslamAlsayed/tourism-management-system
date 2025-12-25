<?php

namespace App\Http\Requests\TourGuide;

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
        $tourGuideId = $this->route('tour_guide'); // Get ID from route

        return [
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],

            'currency_id' => ['nullable', 'exists:currencies,id'],
            'guide_type_id' => ['required', 'exists:tour_guide_types,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],

            'state_id' => ['nullable', 'array'],
            'city_id' => ['nullable', 'array'],

            'language_id' => ['nullable'],
            'language_id.*' => ['integer', 'exists:languages,id'],

            'email' => ['nullable', 'email', 'max:255', Rule::unique('tour_guides', 'email')->ignore($tourGuideId)],
            'mobile_01' => ['nullable', 'string', 'max:20'],
            'mobile_02' => ['nullable', 'string', 'max:20'],
            'home_city' => ['nullable', 'string', 'max:255'],
            'birth_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'gender' => ['nullable', 'in:male,female'],
            'national_guide_id' => ['nullable', 'string', 'max:100'],

            'tourism_ministry_code' => ['nullable', 'string', 'max:100'],
            'fd_day_fees' => ['nullable', 'numeric', 'min:0'],
            'hd_day_fees' => ['nullable', 'numeric', 'min:0'],
            'extra_fees_1' => ['nullable', 'numeric', 'min:0'],
            'extra_fees_2' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000']
        ];
    }
}