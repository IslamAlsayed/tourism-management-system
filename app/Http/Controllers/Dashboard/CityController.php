<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cities\CreateCitiesRequest;
use App\Http\Requests\Cities\UpdateCitiesRequest;

class CityController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.cities.index');
    }

    public function create()
    {
        $states = State::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        return view('pages.dashboard.cities.create', compact('countries', 'states'));
    }

    public function store(CreateCitiesRequest $request)
    {
        $validated = $request->validated();
        $created = City::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->route('cities.create')->with('success', __('main.messages.city_created'));
            }
            return redirect()->route('cities.index')->with('success', __('main.messages.city_created'));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.city_creation_failed'));
    }

    public function edit($id)
    {
        $city = City::with(['country', 'state'])->findOrFail($id);
        $states = State::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        return view('pages.dashboard.cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(UpdateCitiesRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $validated = $request->validated();

        $updated = $city->update($validated);
        if ($updated) {
            return redirect()->route('cities.index')->with('success', __('main.messages.city_updated'));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.city_update_failed'));
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $deleted = $city->delete();
        if ($deleted) {
            return redirect()->route('cities.index')->with('success', __('main.messages.city_deleted'));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.city_deletion_failed'));
    }
}