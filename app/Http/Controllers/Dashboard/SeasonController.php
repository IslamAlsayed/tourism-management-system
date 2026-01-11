<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Season;
use App\Models\Restaurant;
use App\Models\Accommodation;
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
        $accommodations = Accommodation::orderBy('name')->get(['id', 'name']);
        $restaurants = Restaurant::orderBy('name')->get(['id', 'name']);
        return view('pages.dashboard.seasons.create', compact('accommodations', 'restaurants'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $created = Season::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.season')]))
                : redirect()->route('seasons.index', ['type' => $request->input('type')])->with('success', __('messages.type_created', ['type' => __('main.season')])))
            : redirect()->route('seasons.index', ['type' => $request->input('type')])->with('error', __('messages.type_creation_failed', ['type' => __('main.season')]));
    }

    public function show($id)
    {
        $season = Season::with((new Season)->getRelationshipNames())->find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        return view('pages.dashboard.seasons.show', compact('season'));
    }

    public function edit($id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        return view('pages.dashboard.seasons.edit', compact('season'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $updated = $season->update($validated);
        return $updated
            ? redirect()->route('seasons.index', ['type' => $request->input('type')])->withSuccess(__('messages.type_updated', ['type' => __('main.season')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.season')]));
    }

    public function destroy($id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        $deleted = $season->delete();
        return $deleted
            ? redirect()->route('seasons.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.season')]))
            : redirect()->route('seasons.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.season')]));
    }
}