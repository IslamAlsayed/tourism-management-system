<?php

namespace App\Http\Requests\Accommodations\Rate;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'accommodation_id' => 'required|exists:accommodations,id',
            'season_id' => 'required|exists:seasons,id',
            'meal_type_id' => 'required|exists:meal_types,id',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'is_supplement' => 'boolean',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'accommodation_id.required' => 'الإقامة مطلوبة.',
            'season_id.required' => 'الموسم مطلوب.',
            'meal_type_id.required' => 'نوع الوجبة مطلوب.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
            'is_supplement' => $this->has('is_supplement') ? filter_var($this->is_supplement, FILTER_VALIDATE_BOOLEAN) : true,
        ]);
    }
}