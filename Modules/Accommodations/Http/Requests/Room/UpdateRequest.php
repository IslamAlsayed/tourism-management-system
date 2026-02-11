<?php

namespace Modules\Accommodations\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'model_id' => 'nullable|string|max:255',
            'model_type' => 'nullable|string|max:255',
            'currency_id' => 'nullable|integer|exists:currencies,id',
            'name' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'max_occupancy' => 'nullable|integer|min:1',
            'occupancy_details' => 'nullable|string|max:500',
            'price_per_person_double' => 'nullable|numeric|min:0',
            'single_room_supplement' => 'nullable|numeric|min:0',
            'triple_room_discount' => 'nullable|numeric|min:0',
            'third_person_price' => 'nullable|numeric|min:0',
            'extra_bed_price' => 'nullable|numeric|min:0',
            'sea_view_supplement' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
