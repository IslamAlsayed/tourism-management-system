<?php

namespace App\Http\Requests\Accommodations\Season;

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
            'season_from' => 'required|date',
            'season_to' => 'required|date|after:season_from',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الموسم مطلوب.',
            'name_ar.required' => 'الاسم بالعربية مطلوب.',
            'season_from.required' => 'تاريخ البداية مطلوب.',
            'season_to.required' => 'تاريخ النهاية مطلوب.',
            'season_to.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
        ]);
    }
}
