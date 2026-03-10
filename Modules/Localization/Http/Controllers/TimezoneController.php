<?php

namespace Modules\Localization\Http\Controllers;

use Modules\Localization\Entities\Timezone;
use Illuminate\Routing\Controller;
use Modules\Localization\Http\Requests\Timezone\StoreRequest;
use Modules\Localization\Http\Requests\Timezone\UpdateRequest;

class TimezoneController extends Controller
{
    public function index()
    {
        return view('localization::timezones.index');
    }

    public function create()
    {
        return view('localization::timezones.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Timezone::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.timezone')]))
                : redirect()->route('dashboard.localization.timezones.index')->with('success', __('messages.type_created', ['type' => __('main.timezone')])))
            : redirect()->route('dashboard.localization.timezones.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.timezone')]));
    }

    public function show($id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.timezone')]));
        return view('localization::timezones.show', compact('timezone'));
    }

    public function edit($id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.timezone')]));
        return view('localization::timezones.edit', compact('timezone'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.timezone')]));
        $validated = $request->validated();
        $updated = $timezone->update($validated);
        return $updated
            ? redirect()->route('dashboard.localization.timezones.index')->with('success', __('messages.type_updated', ['type' => __('main.timezone')]))
            : redirect()->back()->with('error', __('messages.type_update_failed', ['type' => __('main.timezone')]));
    }

    public function destroy($id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.timezone')]));
        $deleted = $timezone->delete();
        return $deleted
            ? redirect()->route('dashboard.localization.timezones.index')->with('success', __('messages.type_deleted', ['type' => __('main.timezone')]))
            : redirect()->route('dashboard.localization.timezones.index')->with('error', __('messages.type_deletion_failed', ['type' => __('main.timezone')]));
    }
}
