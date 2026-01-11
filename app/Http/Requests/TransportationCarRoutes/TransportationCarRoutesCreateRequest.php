<?php

namespace App\Http\Requests\TransportationCarRoutes;

use Illuminate\Foundation\Http\FormRequest;

class TransportationCarRoutesCreateRequest extends FormRequest
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
            'route' => ['required', 'string', 'max:255'],
            'route_ar' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'min:0.1'],
            'distance' => ['required', 'string', 'min:0.1', 'max:255'],
            'seats' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'decimal:0,2', 'min:0.1'],
            'car_route_id' => ['required', 'string', 'exists:transportations_car_routes,id'],
            'currency_id' => ['required', 'string', 'exists:currencies,id'],
        ];
    }
}