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

    public function edit($id)
    {
        $city = City::with('country')->findOrFail($id);
        return view('pages.dashboard.cities.edit', compact('city'));
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
            return redirect()->route('cities.index')->with('success', 'City updated successfully');
        }

        return redirect()->route('cities.index')->with('error', 'City update failed');
    }
}