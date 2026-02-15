<?php

namespace Modules\EntryPoints\Http\Controllers;

use Modules\Geography\Entities\Region;
use Illuminate\Routing\Controller;
use Modules\EntryPoints\Entities\Airport;
use Modules\EntryPoints\Http\Requests\EntryPoint\StoreRequest;
use Modules\EntryPoints\Http\Requests\EntryPoint\UpdateRequest;

class AirportController extends Controller
{
    public function index()
    {
        return view('entrypoints::airports.index');
    }

    public function create()
    {
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        return view('entrypoints::airports.create', compact('crossing_port_types'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Airport::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.airport')]))
                : redirect()->route('entrypoints.index')->with('success', __('messages.type_created', ['type' => __('main.airport')])))
            : redirect()->route('entrypoints.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.airport')]));
    }

    public function show($id)
    {
        $EntryPoint = Airport::with((new Airport)->getRelationshipNames())->find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airport')]));
        return view('entrypoints::airports.show', compact('EntryPoint'));
    }

    public function edit($id)
    {
        $EntryPoint = Airport::find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airport')]));
        $regions = Region::orderBy('name')->get();
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        return view('entrypoints::airports.edit', compact('EntryPoint', 'crossing_port_types'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $EntryPoint = Airport::find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airport')]));
        $validated = $request->validated();
        $updated = $EntryPoint->update($validated);
        return $updated
            ? redirect()->route('entrypoints.index')->withSuccess(__('messages.type_updated', ['type' => __('main.airport')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.airport')]));
    }

    public function destroy($id)
    {
        $EntryPoint = Airport::find($id);
        if (!$EntryPoint)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airport')]));
        $deleted = $EntryPoint->delete();
        return $deleted
            ? redirect()->route('entrypoints.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.airport')]))
            : redirect()->route('entrypoints.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.airport')]));
    }

    /**
     * Show specific filtered of crossing ports (land, airports, seaports)
     */
    public function filtered($filtered)
    {
        $filtered = singularLowerCaseName($filtered, '_');
        $validTypes = config('helpers.crossing_port_types');
        if (!isset($validTypes[$filtered]))
            return redirect()->route('entrypoints.index')->withError(__('messages.invalid_type'));
        $typeValue = $validTypes[$filtered];
        $typeLabel = ucfirst(str_replace('_', ' ', $typeValue));
        return view('entrypoints::airports.filtered', compact('filtered', 'typeValue', 'typeLabel'));
    }
}
