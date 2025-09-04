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
            // hotel picks are optional in quote; make them nullable if not mandatory
            'hotel_id' => 'nullable|exists:hotels,id',
            'hotel_room_type_id' => 'nullable|exists:hotel_room_types,id',
            'hotel_season_id' => 'nullable|exists:hotel_seasons,id',

            // transportation
            'transportation_company_ids' => 'nullable|array',
            'transportation_company_ids.*' => 'exists:transportation_companies,id',

            // allow optional per-day price / days (arrays aligned with ids by index)
            'transport_days' => 'nullable|array',
            'transport_days.*' => 'nullable|integer|min:1',
            'transport_price_per_day' => 'nullable|array',
            'transport_price_per_day.*' => 'nullable|numeric|min:0',

            // other services
            'other_service_ids' => 'nullable|array',
            'other_service_ids.*' => 'exists:other_services,id',
            'service_qty' => 'nullable|array',
            'service_qty.*' => 'nullable|integer|min:1',
            'service_unit_price' => 'nullable|array',
            'service_unit_price.*' => 'nullable|numeric|min:0',

            // suppliers
            'supplier_ids' => 'nullable|array',
            'supplier_ids.*' => 'exists:suppliers,id',
        ];
    }
}