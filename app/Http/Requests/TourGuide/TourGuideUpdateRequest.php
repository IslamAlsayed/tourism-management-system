<?php

namespace App\Http\Requests\TourGuide;

use Illuminate\Foundation\Http\FormRequest;

class TourGuideUpdateRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'max:255', 'unique:tour_guides,email,' . $tourGuideId],
            'mobile_01' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female'],
            'guide_type_id' => ['nullable', 'exists:tour_guide_types,id'],
            'country_id' => ['nullable', 'exists:countries,id'],

            'name_ar' => ['nullable', 'string', 'max:255'],
            'mobile_02' => ['nullable', 'string', 'max:20'],
            'home_city' => ['nullable', 'string', 'max:255'],
            'birth_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'photo' => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg,gif,svg'],
            'national_guide_id' => ['nullable', 'string', 'max:100'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'languages_ids' => ['nullable', 'array'],
            'languages_ids.*' => ['exists:languages,id'],

            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],

            'state_id' => ['nullable', 'array'],
            'state_id.*' => ['integer', 'exists:states,id'],

            'city_id' => ['nullable', 'array'],
            'city_id.*' => ['integer', 'exists:cities,id'],

            'tourism_ministry_code' => ['nullable', 'string', 'max:100'],
            'fd_day_fees' => ['nullable', 'numeric', 'min:0'],
            'hd_day_fees' => ['nullable', 'numeric', 'min:0'],
            'extra_fees_1' => ['nullable', 'numeric', 'min:0'],
            'extra_fees_2' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:1000']
        ];
    }
}