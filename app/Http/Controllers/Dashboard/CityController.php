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
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.city')]));
            }
            return redirect()->route('cities.index')->with('success', __('main.messages.type_created', ['type' => __('main.city')]));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.city')]));
    }

    public function edit($id)
    {
        $city = City::with(['country', 'state'])->find($id);
        if (!$city) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.city')]));
        }
        $states = State::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        return view('pages.dashboard.cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(UpdateCitiesRequest $request, $id)
    {
        $city = City::find($id);
        if (!$city) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.city')]));
        }
        $validated = $request->validated();

        $updated = $city->update($validated);
        if ($updated) {
            return redirect()->route('cities.index')->with('success', __('main.messages.type_updated', ['type' => __('main.city')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.city')]));
    }

    public function destroy($id)
    {
        $city = City::find($id);
        if (!$city) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.city')]));
        }
        $deleted = $city->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.city')]));
        }

        return redirect()->route('cities.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.city')]));
    }
}