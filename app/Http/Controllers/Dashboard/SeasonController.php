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
        if ($request->input('model_type') == 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') == 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
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
        $season = Season::with('model')->find($id);
        if (!$season) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        }
        return view('pages.dashboard.seasons.show', compact('season'));
    }

    public function edit($id)
    {
        $season = Season::with('model')->find($id);
        if (!$season) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        }
        return view('pages.dashboard.seasons.edit', compact('season'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        }
        $validated = $request->validated();
        if ($request->input('model_type') === 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') === 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
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
            return redirect()->route('seasons.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.season')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.season')]));
    }
}