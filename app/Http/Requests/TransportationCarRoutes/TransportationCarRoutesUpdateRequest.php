<?php

namespace App\Http\Requests\TransportationCarRoutes;

use Illuminate\Foundation\Http\FormRequest;

class TransportationCarRoutesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'route' => ['nullable', 'string', 'max:255'],
            'route_ar' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'min:0.1'],
            'distance' => ['nullable', 'string', 'min:0.1', 'max:255'],
            'seats' => ['nullable', 'integer', 'min:1'],
            'price' => ['nullable', 'decimal:0,2', 'min:0.1'],
            'car_route_id' => ['nullable', 'string', 'exists:transportations_car_routes,id'],
            'currency_id' => ['nullable', 'string', 'exists:currencies,id'],
        ];
    }
}
