<?php

namespace App\Http\Requests\Accommodations\Rate;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRateRequest extends FormRequest
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
            'room_type_id' => 'required|exists:room_types,id',
            'price_per_person_double' => 'required|numeric|min:0',
            'single_room_supplement' => 'nullable|numeric|min:0',
            'triple_room_discount' => 'nullable|numeric|min:0',
            'third_person_price' => 'nullable|numeric|min:0',
            'extra_bed_price' => 'nullable|numeric|min:0',
            'sea_view_supplement' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'accommodation_id.required' => 'الإقامة مطلوبة.',
            'season_id.required' => 'الموسم مطلوب.',
            'room_type_id.required' => 'نوع الغرفة مطلوب.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
        ]);
    }
}