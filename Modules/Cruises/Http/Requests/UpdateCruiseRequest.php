<?php

namespace Modules\Cruises\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCruiseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cruiseId = $this->route('cruise') ? $this->route('cruise')->id : null;

        return [
            'company_id' => 'nullable|exists:users,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cruises')->ignore($cruiseId),
            ],
            'name_ar' => 'nullable|string|max:255',
            'vessel_class' => 'nullable|string|max:100', // e.g., Standard, Luxury, Mega
            'type' => 'nullable|string|max:100',         // e.g., Ocean, River
            'total_cabins' => 'nullable|integer|min:0',
            'deck_count' => 'nullable|integer|min:0',
            'built_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'renovated_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'length_meters' => 'nullable|numeric|min:0',
            'draft_meters' => 'nullable|numeric|min:0',
            'policies' => 'nullable|array',
            'is_active' => 'boolean',
            'is_chartered' => 'boolean',
            'photo' => 'nullable|image|max:2048',
            'region_id' => 'nullable|exists:regions,id',
            'subregion_id' => 'nullable|exists:subregions,id',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'main_start_point_id' => 'nullable|exists:cities,id',
            'main_end_point_id' => 'nullable|exists:cities,id',
            'vessel_nationality_id' => 'nullable|exists:countries,id',
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
