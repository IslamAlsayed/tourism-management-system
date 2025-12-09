<?php

namespace App\Http\Requests\Accommodations\Accommodation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $accommodationId = $this->route('accommodation');
        
        return [
            'name' => 'required|string|max:255|unique:accommodations,name,' . $accommodationId,
            'name_ar' => 'required|string|max:255',
            'classification' => 'nullable|string|max:255',
            'stars' => 'nullable|integer|min:1|max:5',
            'description' => 'nullable|string|max:5000',
            'is_active' => 'boolean',
            'accommodation_type_id' => 'required|exists:accommodation_types,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'general_mobile' => 'nullable|string|max:20',
            'general_email' => 'nullable|email|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'contact_position' => 'nullable|string|max:255',
            'contact_mobile' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'region_id' => 'nullable|exists:regions,id',
            'subregion_id' => 'nullable|exists:subregions,id',
            'street' => 'nullable|string|max:500',
            'box' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'contract_file_path' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الإقامة مطلوب.',
            'name.unique' => 'اسم الإقامة موجود مسبقاً.',
            'name_ar.required' => 'الاسم بالعربية مطلوب.',
            'accommodation_type_id.required' => 'نوع الإقامة مطلوب.',
            'country_id.required' => 'البلد مطلوب.',
            'city_id.required' => 'المدينة مطلوبة.',
        ];
    }
}
