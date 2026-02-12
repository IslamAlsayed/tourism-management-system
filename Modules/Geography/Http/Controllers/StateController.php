<?php

namespace Modules\Geography\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Geography\Entities\State;
use Modules\Geography\Http\Requests\State\StoreRequest;
use Modules\Geography\Http\Requests\State\UpdateRequest;

class StateController extends Controller
{
    use PhotoUploadTrait;

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
        $state = State::create($validated);
        if (!$state)
            return redirect()->route('dashboard.geography.states.index')->withError(__('messages.type_creation_failed', ['type' => __('main.state')]));
        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $state, 'photo', 'states');
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
        if ($request->input('remove_photo') && $request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $state, 'photo', 'states');
        }
        $updated = $state->update($validated);
        return $updated
            ? redirect()->route('dashboard.geography.states.index')->withSuccess(__('messages.type_updated', ['type' => __('main.state')]))
            : redirect()->route('dashboard.geography.states.index')->withError(__('messages.type_update_failed', ['type' => __('main.state')]));
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