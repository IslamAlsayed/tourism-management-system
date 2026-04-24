<?php

namespace Modules\EntryPoints\Http\Controllers;

use Modules\Geography\Entities\Region;
use Illuminate\Routing\Controller;
use Modules\EntryPoints\Entities\Landcrossing;
use Modules\EntryPoints\Http\Requests\EntryPoint\StoreRequest;
use Modules\EntryPoints\Http\Requests\EntryPoint\UpdateRequest;

class LandcrossingController extends Controller
{
    public function index()
    {
        return view('entrypoints::land-crossings.index');
    }

    public function create()
    {
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        return view('entrypoints::land-crossings.create', compact('crossing_port_types'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Landcrossing::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.land-crossing')]))
                : redirect()->route('dashboard.entrypoints.land-crossings.index')->with('success', __('messages.type_created', ['type' => __('main.land-crossing')])))
            : redirect()->route('dashboard.entrypoints.land-crossings.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.land-crossing')]));
    }

    public function show($id)
    {
        $EntryPoint = Landcrossing::with((new Landcrossing)->getRelationshipNames())->find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.land-crossing')]));
        return view('entrypoints::land-crossings.show', compact('EntryPoint'));
    }

    public function edit($id)
    {
        $EntryPoint = Landcrossing::find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.land-crossing')]));
        $regions = Region::orderBy('name')->get();
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        return view('entrypoints::land-crossings.edit', compact('EntryPoint', 'crossing_port_types'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $EntryPoint = Landcrossing::find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.land-crossing')]));
        $validated = $request->validated();
        $updated = $EntryPoint->update($validated);
        return $updated
            ? redirect()->route('dashboard.entrypoints.land-crossings.index')->withSuccess(__('messages.type_updated', ['type' => __('main.land-crossing')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.land-crossing')]));
    }

    public function destroy($id)
    {
        $EntryPoint = Landcrossing::find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.land-crossing')]));
        $deleted = $EntryPoint->delete();
        return $deleted
            ? redirect()->route('dashboard.entrypoints.land-crossings.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.land-crossing')]))
            : redirect()->route('dashboard.entrypoints.land-crossings.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.land-crossing')]));
    }

    /**
     * Show specific filtered of crossing ports (land, airports, seaports)
     */
    public function filtered($filtered)
    {
        $filtered = singularLowerCaseName($filtered, '_');
        $validTypes = config('helpers.crossing_port_types');
        if (!isset($validTypes[$filtered]))
            return redirect()->route('dashboard.entrypoints.land-crossings.index')->withError(__('messages.invalid_type'));
        $typeValue = $validTypes[$filtered];
        $typeLabel = ucfirst(str_replace('_', ' ', $typeValue));
        return view('entrypoints::land-crossings.filtered', compact('filtered', 'typeValue', 'typeLabel'));
    }
}
