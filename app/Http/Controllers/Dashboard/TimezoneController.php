<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Timezone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Timezone\StoreRequest;
use App\Http\Requests\Timezone\UpdateRequest;

class TimezoneController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.timezones.index');
    }

    public function create()
    {
        return view('pages.dashboard.timezones.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Timezone::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.timezone')]))
                : redirect()->route('timezones.index')->with('success', __('messages.type_created', ['type' => __('main.timezone')])))
            : redirect()->route('timezones.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.timezone')]));
    }

    public function show($id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.timezone')]));
        return view('pages.dashboard.timezones.show', compact('timezone'));
    }

    public function edit($id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.timezone')]));
        return view('pages.dashboard.timezones.edit', compact('timezone'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.timezone')]));
        $validated = $request->validated();
        $updated = $timezone->update($validated);
        return $updated
            ? redirect()->route('timezones.index')->withSuccess(__('messages.type_updated', ['type' => __('main.timezone')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.timezone')]));
    }

    public function destroy($id)
    {
        $timezone = Timezone::find($id);
        if (!$timezone)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.timezone')]));
        $deleted = $timezone->delete();
        return $deleted
            ? redirect()->route('timezones.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.timezone')]))
            : redirect()->route('timezones.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.timezone')]));
    }
}