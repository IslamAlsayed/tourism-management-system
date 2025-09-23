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
        $states = State::with('country')->paginate(getPaginate());
        $totalStates = State::count();
        return view('pages.dashboard.states.index', compact('states', 'totalStates'));
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
            return redirect()->route('states.index')->with('success', __('main.messages.state_created'));
        }

        return redirect()->route('states.index')->with('error', __('main.messages.state_creation_failed'));
    }

    public function edit($id)
    {
        $state = State::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        $regions = Country::orderBy('name')->get();
        return view('pages.dashboard.states.edit', compact('state', 'countries', 'regions'));
    }

    public function update(StateUpdateRequest $request, $id)
    {
        $state = State::findOrFail($id);
        $validated = $request->validated();

        $updated = $state->update($validated);
        if ($updated) {
            return redirect()->route('states.index')->with('success', __('main.messages.state_updated'));
        }

        return redirect()->route('states.index')->with('error', __('main.messages.state_updated_failed'));
    }
}