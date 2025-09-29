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
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'mobile_01' => ['nullable', 'string', 'max:20'],
            'mobile_02' => ['nullable', 'string', 'max:20'],
            'home_city' => ['nullable', 'string', 'max:255'],
            'birth_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y'))],
            'gender' => ['nullable', 'string', 'max:10'],
            'national_guide_id' => ['nullable', 'string', 'max:100'],
            'country_id' => ['nullable', 'string', 'max:50', 'exists:restaurants,id'],
            'currency_id' => ['nullable', 'string', 'max:50', 'exists:restaurants,id'],
            'guide_type' => ['nullable', 'string', 'max:255'], // modify as needed
            'tourism_ministry_code' => ['nullable', 'string', 'max:100'],
            'fd_day_fees' => ['nullable', 'numeric', 'min:0'],
            'hd_day_fees' => ['nullable', 'numeric', 'min:0'],
            'extra_fees_1' => ['nullable', 'numeric', 'min:0'],
            'extra_fees_2' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:500']
        ];
    }
}