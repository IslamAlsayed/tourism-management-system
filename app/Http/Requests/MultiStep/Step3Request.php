<?php

namespace App\Http\Requests\MultiStep;

use Illuminate\Foundation\Http\FormRequest;

class Step3Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'itinerary' => 'required|array|min:1',
            'itinerary.*.day_number' => 'required|integer|min:1',
            'itinerary.*.city_id' => 'nullable|exists:cities,id',
            'itinerary.*.description' => 'nullable|string',
        ];
    }
}
