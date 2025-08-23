<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::paginate(10);
        $totalCount = Country::count();
        return view('pages.dashboard.countries.index', compact('countries', 'totalCount'));
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('pages.dashboard.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
        ]);

        $updated = $country->update($validated);
        if ($updated) {
            return redirect()->route('countries.index')->with('success', 'Country updated successfully');
        }

        return redirect()->route('countries.index')->with('error', 'Country update failed');
    }
}