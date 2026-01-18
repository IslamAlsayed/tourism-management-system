<?php

namespace App\Http\Requests\Timezone;

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
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'abbreviation_dst' => 'nullable|string|max:10',
            'offset' => 'required|numeric',
            'offset_dst' => 'nullable|numeric',
            'country_code' => 'required|string|size:2',
            'gmt_offset_name' => 'nullable|string|max:50',
            'gmt_offset_name_dst' => 'nullable|string|max:50',
            'supports_dst' => 'nullable|boolean',
            'region' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ];
    }
}