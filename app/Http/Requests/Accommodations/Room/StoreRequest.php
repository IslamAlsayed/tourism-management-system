<?php

namespace App\Http\Requests\Accommodations\Room;

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
            'max_occupancy' => 'required|integer|min:1|max:20',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم نوع الغرفة مطلوب.',
            'name_ar.required' => 'الاسم بالعربية مطلوب.',
            'max_occupancy.required' => 'الحد الأقصى للإقامة مطلوب.',
            'max_occupancy.min' => 'الحد الأقصى للإقامة يجب أن يكون على الأقل 1.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
        ]);
    }
}
