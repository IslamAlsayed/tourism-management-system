<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::paginate(10);
        return view('pages.admin.countries.index', compact('countries'));
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('pages.admin.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
        ]);

        $country->update($validated);
        return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully');
    }
}
