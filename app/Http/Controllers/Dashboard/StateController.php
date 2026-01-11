<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Timezone;
use App\Http\Controllers\Controller;
use App\Http\Requests\State\StoreRequest;
use App\Http\Requests\State\UpdateRequest;

class StateController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.states.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id']);
        return view('pages.dashboard.states.create', compact('regions', 'timezones'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        unset($data['city_id']);
        $state = State::create($data);
        if (!$state) {
            return redirect()->route('states.index')->withError(__('messages.type_creation_failed', ['type' => __('main.state')]));
        }
        $cityIds = [];
        if ($request->boolean('all_cities') && isset($data['country_id'])) {
            $cityIds = City::where('country_id', $data['country_id'])->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        if (!empty($cityIds)) {
            $state->cities()->sync($cityIds);
        }
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.state')]))
            : redirect()->route('states.index')->withSuccess(__('messages.type_created', ['type' => __('main.state')]));
    }

    public function show($id)
    {
        $state = State::with((new State)->getRelationshipNames())->find($id);
        if (!$state) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        }
        return view('pages.dashboard.states.show', compact('state'));
    }

    public function edit($id)
    {
        $state = State::find($id);
        if (!$state) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        }
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id']);
        return view('pages.dashboard.states.edit', compact('state', 'regions', 'timezones'));
    }
    public function update(UpdateRequest $request, $id)
    {
        $state = State::find($id);
        if (!$state) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        }
        $data = $request->validated();
        unset($data['city_id']);
        $state->update($data);
        $cityIds = [];
        if ($request->boolean('all_cities') && isset($data['country_id'])) {
            $cityIds = City::where('country_id', $data['country_id'])->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $state->cities()->sync($cityIds);
        return redirect()->route('states.index')->withSuccess(__('messages.type_updated', ['type' => __('main.state')]));
    }

    public function destroy($id)
    {
        $state = State::find($id);
        if (!$state) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        }
        $deleted = $state->delete();
        return $deleted
            ? redirect()->route('states.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.state')]))
            : redirect()->route('states.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.state')]));
    }
}