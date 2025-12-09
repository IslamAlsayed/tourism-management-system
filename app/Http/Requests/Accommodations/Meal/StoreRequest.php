<?php

namespace App\Http\Requests\Accommodations\Meal;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_included' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم نوع الوجبة مطلوب.',
            'name_ar.required' => 'الاسم بالعربية مطلوب.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_included' => $this->has('is_included') ? filter_var($this->is_included, FILTER_VALIDATE_BOOLEAN) : false,
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
        ]);
    }
}
