<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\State;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\States\StateCreateRequest;
use App\Http\Requests\States\StateUpdateRequest;
use App\Http\Requests\States\UpdateStatesRequest;

class StateController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.states.index');
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.states.create', compact('countries', 'regions'));
    }

    public function store(StateCreateRequest $request)
    {
        $validated = $request->validated();
        $state = State::create($validated);

        if ($state) {
            return redirect()->route('states.index')->with('success', __('main.messages.type_created', ['type' => __('main.state')]));
        }

        return redirect()->route('states.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.state')]));
    }

    public function edit($id)
    {
        $state = State::find($id);
        if (!$state) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.state')]));
        }
        $countries = Country::orderBy('name')->get();
        $regions = Country::orderBy('name')->get();
        return view('pages.dashboard.states.edit', compact('state', 'countries', 'regions'));
    }

    public function update(StateUpdateRequest $request, $id)
    {
        $state = State::find($id);
        if (!$state) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.state')]));
        }
        $validated = $request->validated();

        $updated = $state->update($validated);
        if ($updated) {
            return redirect()->route('states.index')->with('success', __('main.messages.type_updated', ['type' => __('main.state')]));
        }

        return redirect()->route('states.index')->with('error', __('main.messages.type_updated_failed', ['type' => __('main.state')]));
    }
}