<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\State;
use App\Models\Region;
use App\Models\Timezone;
use App\Http\Controllers\Controller;
use App\Http\Requests\States\StateCreateRequest;
use App\Http\Requests\States\StateUpdateRequest;

class StateController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.states.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.states.create', compact('regions', 'timezones'));
    }

    public function store(StateCreateRequest $request)
    {
        $validated = $request->validated();
        if ($request['state_id']) {
            $validated['state_id'] = array_unique($validated['state_id']);
        }
        if ($request['city_id']) {
            $validated['city_id'] = array_unique($validated['city_id']);
        }
        $state = State::create($validated);
        if ($state) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.state')]));
            }
            return redirect()->route('states.index')->withSuccess(__('messages.type_created', ['type' => __('main.state')]));
        }
        return redirect()->route('states.index')->withError(__('messages.type_creation_failed', ['type' => __('main.state')]));
    }

    public function edit($id)
    {
        $state = State::find($id);
        if (!$state) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        }
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.states.edit', compact('state', 'regions', 'timezones'));
    }

    public function update(StateUpdateRequest $request, $id)
    {
        $state = State::find($id);
        if (!$state) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        }
        $validated = $request->validated();
        if ($request['state_id']) {
            $validated['state_id'] = array_unique($validated['state_id']);
        }
        if ($request['city_id']) {
            $validated['city_id'] = array_unique($validated['city_id']);
        }
        $updated = $state->update($validated);
        if ($updated) {
            return redirect()->route('states.index')->withSuccess(__('messages.type_updated', ['type' => __('main.state')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.state')]));
    }
}