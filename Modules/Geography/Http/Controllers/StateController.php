<?php

namespace Modules\Geography\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use App\Http\Requests\State\StoreRequest;
use App\Http\Requests\State\UpdateRequest;

class StateController extends Controller
{
    public function index()
    {
        return view('geography::states.index');
    }

    public function create()
    {
        return view('geography::states.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        unset($validated['city_id']);
        $state = State::create($validated);
        if (!$state)
            return redirect()->route('dashboard.geography.states.index')->withError(__('messages.type_creation_failed', ['type' => __('main.state')]));
        $cityIds = [];
        if ($request->boolean('all_cities') && isset($validated['country_id'])) {
            $cityIds = City::where('country_id', $validated['country_id'])->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        if (!empty($cityIds)) {
            $state->cities()->sync($cityIds);
        }
        return $state
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.state')]))
                : redirect()->route('dashboard.geography.states.index')->withSuccess(__('messages.type_created', ['type' => __('main.state')])))
            : redirect()->back()->withError(__('messages.type_creation_failed', ['type' => __('main.state')]));
    }

    public function show($id)
    {
        $state = State::with((new State)->getRelationshipNames())->find($id);
        if (!$state)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        return view('geography::states.show', compact('state'));
    }

    public function edit($id)
    {
        $state = State::find($id);
        if (!$state)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        return view('geography::states.edit', compact('state'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $state = State::find($id);
        if (!$state)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        $validated = $request->validated();
        unset($validated['city_id']);
        $state->update($validated);
        $cityIds = [];
        if ($request->boolean('all_cities') && isset($validated['country_id'])) {
            $cityIds = City::where('country_id', $validated['country_id'])->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $state->cities()->sync($cityIds);
        return redirect()->route('dashboard.geography.states.index')->withSuccess(__('messages.type_updated', ['type' => __('main.state')]));
    }

    public function destroy($id)
    {
        $state = State::find($id);
        if (!$state)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.state')]));
        $deleted = $state->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.states.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.state')]))
            : redirect()->route('dashboard.geography.states.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.state')]));
    }
}
