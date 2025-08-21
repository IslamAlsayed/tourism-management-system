<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->paginate(10);
        return view('pages.admin.cities.index', compact('cities'));
    }

    public function edit($id)
    {
        $city = City::with('country')->findOrFail($id);
        return view('pages.admin.cities.edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        $city->update($validated);
        return redirect()->route('admin.cities.index')->with('success', 'City updated successfully');
    }
}
