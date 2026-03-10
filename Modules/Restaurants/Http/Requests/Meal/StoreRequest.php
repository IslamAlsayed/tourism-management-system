<?php

namespace Modules\Restaurants\Http\Requests\Meal;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'meals' => 'required|array|min:1',
            'meals.*.currency_id' => 'required|integer|exists:currencies,id',
            'meals.*.season_id' => 'nullable|integer|exists:seasons,id',
            'meals.*.name' => 'required|string|max:255',
            'meals.*.name_ar' => 'nullable|string|max:255',
            'meals.*.type' => 'required|string|max:255',
            'meals.*.min_group_size' => 'nullable|integer|min:1',
            'meals.*.fit_price_adult' => 'nullable|numeric|min:0',
            'meals.*.fit_price_child_6_11' => 'nullable|numeric|min:0',
            'meals.*.fit_price_child_under_6' => 'nullable|numeric|min:0',
            'meals.*.group_price_adult' => 'nullable|numeric|min:0',
            'meals.*.group_price_child_6_11' => 'nullable|numeric|min:0',
            'meals.*.group_price_child_under_6' => 'nullable|numeric|min:0',
            'meals.*.is_included' => 'boolean',
            'meals.*.is_supplement' => 'boolean',
            'meals.*.is_active' => 'boolean',
            'meals.*.description' => 'nullable|string|max:1000',
            'meals.*.notes' => 'nullable|string|max:1000',
        ];
    }
}
