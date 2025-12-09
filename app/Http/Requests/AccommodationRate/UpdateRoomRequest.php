<?php

namespace App\Http\Requests\AccommodationRate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'room_id' => 'nullable|exists:rooms,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'price_per_person_double' => 'nullable|numeric|min:0',
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