<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\CrossingPort;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrossingPort\StoreRequest;
use App\Http\Requests\CrossingPort\UpdateRequest;

class CrossingPortController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.crossings-ports.index');
    }

    public function create()
    {
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        return view('pages.dashboard.crossings-ports.create', compact('crossing_port_types'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = CrossingPort::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.crossing_port')]))
                : redirect()->route('crossings-ports.index')->with('success', __('messages.type_created', ['type' => __('main.crossing_port')])))
            : redirect()->route('crossings-ports.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.crossing_port')]));
    }

    public function show($id)
    {
        $crossingPort = CrossingPort::with((new CrossingPort)->getRelationshipNames())->find($id);
        if (!$crossingPort)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        return view('pages.dashboard.crossings-ports.show', compact('crossingPort'));
    }

    public function edit($id)
    {
        $crossingPort = CrossingPort::find($id);
        if (!$crossingPort)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        $regions = Region::orderBy('name')->get();
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        return view('pages.dashboard.crossings-ports.edit', compact('crossingPort', 'crossing_port_types'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $crossingPort = CrossingPort::find($id);
        if (!$crossingPort)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        $validated = $request->validated();
        $updated = $crossingPort->update($validated);
        return $updated
            ? redirect()->route('crossings-ports.index')->withSuccess(__('messages.type_updated', ['type' => __('main.crossing_port')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.crossing_port')]));
    }

    public function destroy($id)
    {
        $crossingPort = CrossingPort::find($id);
        if (!$crossingPort)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        $deleted = $crossingPort->delete();
        return $deleted
            ? redirect()->route('crossings-ports.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.crossing_port')]))
            : redirect()->route('crossings-ports.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.crossing_port')]));
    }

    /**
     * Show specific type of crossing ports (land, airports, seaports)
     */
    public function type($type)
    {
        $type = singularLowerCaseName($type, '_');
        $validTypes = config('helpers.crossing_port_types');
        if (!isset($validTypes[$type]))
            return redirect()->route('crossings-ports.index')->withError(__('messages.invalid_type'));
        $typeValue = $validTypes[$type];
        $typeLabel = ucfirst(str_replace('_', ' ', $typeValue));
        return view('pages.dashboard.crossings-ports.type', compact('type', 'typeValue', 'typeLabel'));
    }
}