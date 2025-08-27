<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->paginate(10);
        $totalCities = City::count();
        return view('pages.dashboard.cities.index', compact('cities', 'totalCities'));
    }

    public function create()
    {
        $countries = Country::orderBy('name_ar')->get();
        return view('pages.dashboard.cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'code' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'population' => 'nullable|integer',
            'timezone' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        City::create($validated);

        if ($request->has('save_and_add')) {
            return redirect()->route('cities.create')->with('success', __('main.item_created', ['item' => __('main.city')]) . ' ' . __('main.add_new_city'));
        }

        return redirect()->route('cities.index')->with('success', __('main.item_created', ['item' => __('main.city')]));
    }

    public function edit($id)
    {
        $city = City::with('country')->findOrFail($id);
        $countries = Country::all();
        return view('pages.dashboard.cities.edit', compact('city', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        $updated = $city->update($validated);
        if ($updated) {
            return redirect()->route('cities.index')->with('success', __('main.item_updated', ['item' => __('main.city')]));
        }

        return redirect()->route('cities.index')->with('error', __('main.operation_failed'));
    }
}