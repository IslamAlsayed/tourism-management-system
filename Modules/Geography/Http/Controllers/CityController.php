<?php

namespace Modules\Geography\Http\Controllers;

use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use Illuminate\Routing\Controller;
use App\Http\Requests\City\StoreRequest;
use App\Http\Requests\City\UpdateRequest;

class CityController extends Controller
{
    public function index()
    {
        return view('geography::cities.index');
    }

    public function create()
    {
        return view('geography::cities.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        unset($data['state_id']);
        $city = City::create($data);
        if (!$city)
            return redirect()->route('dashboard.geography.cities.index')->withError(__('messages.type_creation_failed', ['type' => __('main.city')]));
        $stateIds = [];
        if ($request->boolean('all_states') && isset($data['country_id'])) {
            $stateIds = State::where('country_id', $data['country_id'])->pluck('id')->toArray();
        } elseif ($request->filled('state_id')) {
            $stateIds = array_unique((array) $request->input('state_id'));
        }
        if (!empty($stateIds)) {
            $city->states()->sync($stateIds);
        }
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.city')]))
            : redirect()->route('dashboard.geography.cities.index')->withSuccess(__('messages.type_created', ['type' => __('main.city')]));
    }

    public function show($id)
    {
        $city = City::with((new City)->getRelationshipNames())->find($id);
        return $city
            ? view('geography::cities.show', compact('city'))
            : redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
    }

    public function edit($id)
    {
        $city = City::find($id);
        if (!$city)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
        return view('geography::cities.edit', compact('city'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $city = City::find($id);
        if (!$city)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
        $data = $request->validated();
        unset($data['state_id']);
        $city->update($data);
        $stateIds = [];
        if ($request->boolean('all_states') && isset($data['country_id'])) {
            $stateIds = State::where('country_id', $data['country_id'])->pluck('id')->toArray();
        } elseif ($request->filled('state_id')) {
            $stateIds = array_unique((array) $request->input('state_id'));
        }
        $city->states()->sync($stateIds);
        return redirect()->route('dashboard.geography.cities.index')->withSuccess(__('messages.type_updated', ['type' => __('main.city')]));
    }

    public function destroy($id)
    {
        $city = City::find($id);
        if (!$city)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
        $deleted = $city->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.cities.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.city')]))
            : redirect()->route('dashboard.geography.cities.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.city')]));
    }
}
