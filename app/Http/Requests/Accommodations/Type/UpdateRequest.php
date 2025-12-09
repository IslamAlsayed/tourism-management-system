<?php

namespace App\Http\Requests\Accommodations\Type;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $typeId = $this->route('type');

        return [
            'name' => 'required|string|max:255|unique:accommodation_types,name,' . $typeId,
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم النوع مطلوب.',
            'name.unique' => 'اسم النوع موجود مسبقاً.',
            'name_ar.required' => 'الاسم بالعربية مطلوب.',
        ];
    }
}
