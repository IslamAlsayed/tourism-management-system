<?php

namespace App\Http\Requests\AccommodationRate;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'room_id' => 'required|exists:rooms,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'price_per_person_double' => 'required|numeric|min:0',
            'single_room_supplement' => 'nullable|numeric|min:0',
            'triple_room_discount' => 'nullable|numeric|min:0',
            'third_person_price' => 'nullable|numeric|min:0',
            'extra_bed_price' => 'nullable|numeric|min:0',
            'sea_view_supplement' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ];
    }
}