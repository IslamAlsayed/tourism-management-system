<?php

namespace Modules\Cruises\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCruisePortRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:Ocean,River',
            'country_id' => 'nullable|exists:geography_countries,id',
            'city_id' => 'nullable|exists:geography_cities,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
