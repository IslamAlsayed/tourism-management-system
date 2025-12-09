<?php

namespace App\Http\Requests\Accommodations\Rate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'accommodation_id' => 'nullable|exists:accommodations,id',
            'season_id' => 'nullable|exists:seasons,id',
            'meal_type_id' => 'nullable|exists:meal_types,id',
            'price' => 'nullable|numeric|min:0.1',
            'adult_rate' => 'nullable|numeric|min:0',
            'child_rate' => 'nullable|numeric|min:0',
            'infant_rate' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'accommodation_id.nullable' => 'الإقامة مطلوبة.',
            'season_id.nullable' => 'الموسم مطلوب.',
            'meal_type_id.nullable' => 'نوع الوجبة مطلوب.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
        ]);
    }
}