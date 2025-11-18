<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\Region;
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
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.cities.create', get_defined_vars());
    }

    public function store(CreateCitiesRequest $request)
    {
        $data = $request->validated();
        if ($request['state_id']) {
            $data['state_id'] = array_unique($data['state_id']);
        }
        if ($request['city_id']) {
            $data['city_id'] = array_unique($data['city_id']);
        }
        $created = City::create($data);

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
        $city = City::with(['region', 'subregion', 'country'])->find($id);
        if (!$city) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.city')]));
        }
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.cities.edit', get_defined_vars());
    }

    public function update(UpdateCitiesRequest $request, $id)
    {
        $city = City::find($id);
        if (!$city) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.city')]));
        }
        $data = $request->validated();
        if ($request['state_id']) {
            $data['state_id'] = array_unique($data['state_id']);
        }
        if ($request['city_id']) {
            $data['city_id'] = array_unique($data['city_id']);
        }
        $updated = $city->update($data);
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