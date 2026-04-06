<?php

namespace Modules\Cruises\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                    => 'required|string|max:255',
            'name_ar'                 => 'nullable|string|max:255',
            'contact_person'          => 'nullable|string|max:255',
            'phone'                   => 'nullable|string|max:50',
            'email'                   => 'nullable|email|max:255',
            'website'                 => 'nullable|url|max:255',
            'country_id'              => 'nullable|integer|exists:countries,id',
            'region_id'               => 'nullable|integer|exists:regions,id',
            'subregion_id'            => 'nullable|integer|exists:subregions,id',
            'state_id'                => 'nullable|integer|exists:states,id',
            'city_id'                 => 'nullable|integer|exists:cities,id',
            'main_start_point_id'     => 'nullable|integer|exists:cities,id',
            'main_end_point_id'       => 'nullable|integer|exists:cities,id',
            'address'                 => 'nullable|string',
            'type'                    => 'required|in:ship_owner,broker,agency,operator',
            'default_commission_rate' => 'nullable|numeric|min:0|max:100',
            'payment_terms'           => 'nullable|string',
            'contract_start_date'     => 'nullable|date',
            'contract_end_date'       => 'nullable|date|after_or_equal:contract_start_date',
            'notes'                   => 'nullable|string',
        ];
    }
}
