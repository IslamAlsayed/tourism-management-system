<?php

namespace App\Http\Requests\Accommodations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccommodationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // يمكن إضافة صلاحيات هنا لاحقاً
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $accommodationId = $this->route('accommodation'); // الحصول على ID من الرابط

        return [
            // Basic Information
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('accommodations', 'name')->ignore($accommodationId)
            ],
            'name_ar' => 'required|string|max:255',
            'classification' => 'nullable|string|max:255',
            'stars' => 'nullable|integer|min:1|max:5',
            'description' => 'nullable|string|max:5000',
            'is_active' => 'boolean',

            // Type & Currency
            'accommodation_type_id' => 'required|exists:accommodation_types,id',
            'currency_id' => 'nullable|exists:currencies,id',

            // Contact Information
            'general_mobile' => 'nullable|string|max:20',
            'general_email' => 'nullable|email|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:20',

            // Contact Person
            'contact_person' => 'nullable|string|max:255',
            'contact_position' => 'nullable|string|max:255',
            'contact_mobile' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',

            // Location
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

            // Contract
            'contract_file_path' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('main.name'),
            'name_ar' => __('main.name_ar'),
            'classification' => __('main.classification'),
            'stars' => __('main.stars'),
            'description' => __('main.description'),
            'is_active' => __('main.status'),
            'accommodation_type_id' => __('main.accommodation_type'),
            'currency_id' => __('main.currency'),
            'general_mobile' => __('main.general_mobile'),
            'general_email' => __('main.general_email'),
            'email' => __('main.email'),
            'website' => __('main.website'),
            'phone' => __('main.phone'),
            'phone_ext' => __('main.phone_ext'),
            'fax' => __('main.fax'),
            'contact_person' => __('main.contact_person'),
            'contact_position' => __('main.contact_position'),
            'contact_mobile' => __('main.contact_mobile'),
            'contact_email' => __('main.contact_email'),
            'country_id' => __('main.country'),
            'state_id' => __('main.state'),
            'city_id' => __('main.city'),
            'region_id' => __('main.region'),
            'subregion_id' => __('main.subregion'),
            'street' => __('main.street'),
            'box' => __('main.box'),
            'postal_code' => __('main.postal_code'),
            'latitude' => __('main.latitude'),
            'longitude' => __('main.longitude'),
            'contract_file_path' => __('main.contract_file'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الإقامة مطلوب.',
            'name.unique' => 'اسم الإقامة موجود مسبقاً، يرجى اختيار اسم آخر.',
            'name_ar.required' => 'الاسم بالعربية مطلوب.',
            'accommodation_type_id.required' => 'نوع الإقامة مطلوب.',
            'accommodation_type_id.exists' => 'نوع الإقامة المحدد غير موجود.',
            'country_id.required' => 'البلد مطلوب.',
            'country_id.exists' => 'البلد المحدد غير موجود.',
            'city_id.required' => 'المدينة مطلوبة.',
            'city_id.exists' => 'المدينة المحددة غير موجودة.',
            'stars.min' => 'عدد النجوم يجب أن يكون على الأقل 1.',
            'stars.max' => 'عدد النجوم يجب ألا يزيد عن 5.',
            'general_email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'contact_email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'website.url' => 'يرجى إدخال رابط موقع صحيح.',
            'latitude.between' => 'خط العرض يجب أن يكون بين -90 و 90.',
            'longitude.between' => 'خط الطول يجب أن يكون بين -180 و 180.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // تحويل is_active إلى boolean إذا كان موجود
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }

    /**
     * Get validated data with only the fields that should be updated
     */
    public function validatedForUpdate(): array
    {
        $validated = $this->validated();

        // إزالة الحقول الفارغة إذا لم تكن مطلوبة للتحديث
        return array_filter($validated, function ($value) {
            return $value !== null && $value !== '';
        });
    }
}