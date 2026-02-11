<?php

namespace Modules\Accommodations\Http\Controllers;

use Modules\Accommodations\Entities\Season;
use Modules\Restaurants\Entities\Restaurant;
use Modules\Accommodations\Entities\Accommodation;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Http\Requests\Season\StoreRequest;
use Modules\Accommodations\Http\Requests\Season\UpdateRequest;

class SeasonController extends Controller
{
    public function index()
    {
        return view('accommodations::seasons.index');
    }

    public function create()
    {
        $accommodations = Accommodation::orderBy('name')->get(['id', 'name']);
        $restaurants = Restaurant::orderBy('name')->get(['id', 'name']);
        return view('accommodations::seasons.create', compact('accommodations', 'restaurants'));
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
                : redirect()->route('dashboard.accommodations.seasons.index', ['type' => $request->input('type')])->with('success', __('messages.type_created', ['type' => __('main.season')])))
            : redirect()->route('dashboard.accommodations.seasons.index', ['type' => $request->input('type')])->with('error', __('messages.type_creation_failed', ['type' => __('main.season')]));
    }

    public function show($id)
    {
        $season = Season::with((new Season)->getRelationshipNames())->find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        return view('accommodations::seasons.show', compact('season'));
    }

    public function edit($id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        return view('accommodations::seasons.edit', compact('season'));
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
            ? redirect()->route('dashboard.accommodations.seasons.index', ['type' => $request->input('type')])->withSuccess(__('messages.type_updated', ['type' => __('main.season')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.season')]));
    }

    public function destroy($id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        $deleted = $season->delete();
        return $deleted
            ? redirect()->route('dashboard.accommodations.seasons.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.season')]))
            : redirect()->route('dashboard.accommodations.seasons.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.season')]));
    }
}
