<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\CrossingPort;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrossingPort\CrossingPortCreateRequest;
use App\Http\Requests\CrossingPort\CrossingPortUpdateRequest;
use App\Models\Currency;

class CrossingPortController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.crossings-ports.index');
    }

    public function create()
    {
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.crossings-ports.create', get_defined_vars());
    }

    public function store(CrossingPortCreateRequest $request)
    {
        $validated = $request->validated();

        // Handle location arrays (if multi-select)
        if (isset($validated['state_id']) && is_array($validated['state_id'])) {
            $validated['state_id'] = $validated['state_id'][0] ?? null;
        }
        if (isset($validated['city_id']) && is_array($validated['city_id'])) {
            $validated['city_id'] = $validated['city_id'][0] ?? null;
        }

        $created = CrossingPort::create($validated);
        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('main.messages.type_created', ['type' => __('main.crossing_port')]));
            }
            return redirect()->route('crossings-ports.index')->withSuccess(__('main.messages.type_created', ['type' => __('main.crossing_port')]));
        }
        return redirect()->route('crossings-ports.index')->withError(__('main.messages.type_creation_failed', ['type' => __('main.crossing_port')]));
    }

    public function show($id)
    {
        $crossingPort = CrossingPort::with(['region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$crossingPort) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        }
        return view('pages.dashboard.crossings-ports.show', compact('crossingPort'));
    }

    public function edit($id)
    {
        $crossingPort = CrossingPort::find($id);
        if (!$crossingPort) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        }
        $crossing_port_types = array_keys(config('helpers.crossing_port_types'));
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.crossings-ports.edit', get_defined_vars());
    }

    public function update(CrossingPortUpdateRequest $request, $id)
    {
        $crossingPort = CrossingPort::find($id);
        if (!$crossingPort) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        }
        $validated = $request->validated();

        // Handle location arrays (if multi-select)
        if (isset($validated['state_id']) && is_array($validated['state_id'])) {
            $validated['state_id'] = $validated['state_id'][0] ?? null;
        }
        if (isset($validated['city_id']) && is_array($validated['city_id'])) {
            $validated['city_id'] = $validated['city_id'][0] ?? null;
        }

        $updated = $crossingPort->update($validated);
        if ($updated) {
            return redirect()->route('crossings-ports.index')->withSuccess(__('main.messages.type_updated', ['type' => __('main.crossing_port')]));
        }
        return redirect()->back()->withError(__('main.messages.type_update_failed', ['type' => __('main.crossing_port')]));
    }

    public function destroy($id)
    {
        $crossingPort = CrossingPort::find($id);
        if (!$crossingPort) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.crossing_port')]));
        }
        $deleted = $crossingPort->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('main.messages.type_deleted', ['type' => __('main.crossing_port')]));
        }
        return redirect()->back()->withError(__('main.messages.type_deletion_failed', ['type' => __('main.crossing_port')]));
    }

    /**
     * Show specific type of crossing ports (land, airports, seaports)
     */
    public function type($type)
    {
        $type = singularLowerCaseName($type, '_');
        $validTypes = config('helpers.crossing_port_types');
        if (!isset($validTypes[$type])) {
            return redirect()->route('crossings-ports.index')->withError(__('main.messages.invalid_type'));
        }
        $typeValue = $validTypes[$type];
        $typeLabel = ucfirst(str_replace('_', ' ', $typeValue));
        return view('pages.dashboard.crossings-ports.type', get_defined_vars());
    }
}