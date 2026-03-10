<?php

namespace Modules\Restaurants\Http\Requests\Meal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'season_id' => 'nullable|integer|exists:seasons,id',
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'min_group_size' => 'nullable|integer|min:1',
            'fit_price_adult' => 'nullable|numeric|min:0',
            'fit_price_child_6_11' => 'nullable|numeric|min:0',
            'fit_price_child_under_6' => 'nullable|numeric|min:0',
            'group_price_adult' => 'nullable|numeric|min:0',
            'group_price_child_6_11' => 'nullable|numeric|min:0',
            'group_price_child_under_6' => 'nullable|numeric|min:0',
            'is_included' => 'boolean',
            'is_supplement' => 'boolean',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
