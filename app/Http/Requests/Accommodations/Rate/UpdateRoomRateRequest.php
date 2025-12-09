<?php

namespace App\Http\Requests\Accommodations\Rate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRateRequest extends FormRequest
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
            'room_type_id' => 'nullable|exists:room_types,id',
            'price_per_person_double' => 'nullable|numeric|min:0',
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
            'accommodation_id.nullable' => 'الإقامة مطلوبة.',
            'season_id.nullable' => 'الموسم مطلوب.',
            'room_type_id.nullable' => 'نوع الغرفة مطلوب.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
        ]);
    }
}