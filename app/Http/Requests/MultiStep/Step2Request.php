<?php

namespace App\Http\Requests\MultiStep;

use Illuminate\Foundation\Http\FormRequest;

class Step2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hotel_id' => ['required', 'exists:hotels,id'],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'hotel_season_id' => ['required', 'exists:hotel_seasons,id'],
        ];
    }
}