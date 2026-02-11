<?php

namespace Modules\Accommodations\Http\Requests\Room;

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
            'model_id' => 'required_without:model_type|string|max:255',
            'model_type' => 'required_without:model_id|string|max:255',
            'currency_id' => 'required|integer|exists:currencies,id',
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'max_occupancy' => 'required|integer|min:1',
            'occupancy_details' => 'nullable|string|max:500',
            'price_per_person_double' => 'required|numeric|min:0',
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
