<?php

namespace App\Http\Requests\Transportation\Route;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:50|unique:transportations_routes,code',

            // Origin
            'origin_city_id' => 'required|exists:cities,id',
            'origin_address' => 'nullable|string|max:500',
            'origin_latitude' => 'nullable|numeric|between:-90,90',
            'origin_longitude' => 'nullable|numeric|between:-180,180',

            // Destination
            'destination_city_id' => 'required|exists:cities,id|different:origin_city_id',
            'destination_address' => 'nullable|string|max:500',
            'destination_latitude' => 'nullable|numeric|between:-90,90',
            'destination_longitude' => 'nullable|numeric|between:-180,180',

            // Route Details
            'distance' => 'nullable|numeric|min:0|max:9999999.99',
            'estimated_duration' => 'nullable|integer|min:0',
            'route_type' => 'required|in:one_way,round_trip,multi_stop',
            'waypoints' => 'nullable|array',
            'waypoints.*.city_id' => 'required|exists:cities,id',
            'waypoints.*.address' => 'nullable|string|max:500',
            'waypoints.*.latitude' => 'nullable|numeric|between:-90,90',
            'waypoints.*.longitude' => 'nullable|numeric|between:-180,180',

            // Operational
            'is_active' => 'boolean',
            'is_toll_road' => 'boolean',
            'toll_fee' => 'nullable|numeric|min:0|max:999999.99',
            'road_condition' => 'nullable|in:excellent,good,fair,poor',

            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Route name is required',
            'origin_city_id.required' => 'Origin city is required',
            'destination_city_id.required' => 'Destination city is required',
            'destination_city_id.different' => 'Destination city must be different from origin city',
            'route_type.required' => 'Route type is required',
            'route_type.in' => 'Route type must be one_way, round_trip, or multi_stop',
        ];
    }
}