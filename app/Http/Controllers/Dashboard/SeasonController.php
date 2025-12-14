<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Season;
use App\Http\Controllers\Controller;
use App\Http\Requests\Season\StoreRequest;
use App\Http\Requests\Season\UpdateRequest;

class SeasonController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.seasons.index');
    }

    public function create()
    {
        return view('pages.dashboard.seasons.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $season = Season::create($validated);
        if ($season) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.season')]));
            }
            return redirect()->route('seasons.index')->withSuccess(__('messages.type_created', ['type' => __('main.season')]));
        }
        return redirect()->route('seasons.index')->withError(__('messages.type_creation_failed', ['type' => __('main.season')]));
    }

    public function show($id)
    {
        $season = Season::with('accommodations')->find($id);
        if (!$season) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        }
        return view('pages.dashboard.seasons.show', compact('season'));
    }

    public function edit($id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        }
        return view('pages.dashboard.seasons.edit', compact('season'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        }
        $validated = $request->validated();
        $updated = $season->update($validated);
        if ($updated) {
            return redirect()->route('seasons.index')->withSuccess(__('messages.type_updated', ['type' => __('main.season')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.season')]));
    }

    public function destroy($id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        }
        $deleted = $season->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.season')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.season')]));
    }
}