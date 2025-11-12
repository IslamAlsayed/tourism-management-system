<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AirTransport;
use App\Models\Region;
use App\Http\Requests\AirTransport\AirTransportCreateRequest;
use App\Http\Requests\AirTransport\AirTransportUpdateRequest;

class AirTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.dashboard.air-transports.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $airTransportTypes = array_keys(config('helpers.air_transport_types'));
        $airTransportStatuses = array_keys(config('helpers.air_transport_statuses'));
        $airTransportServiceTypes = array_keys(config('helpers.air_transport_service_types'));
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.air-transports.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AirTransportCreateRequest $request)
    {
        try {
            $data = $request->validated();
            // Handle JSON fields
            $jsonFields = ['aircraft_types', 'certifications', 'destinations', 'services', 'cabin_classes', 'partnerships', 'codeshare_agreements'];
            foreach ($jsonFields as $field) {
                if (isset($data[$field]) && is_string($data[$field])) {
                    $data[$field] = explode(',', $data[$field]);
                    $data[$field] = array_map('trim', $data[$field]);
                    $data[$field] = array_filter($data[$field]);
                }
            }

            // Set created_by
            $data['created_by'] = auth()->id();
            $airTransport = AirTransport::create($data);
            return redirect()->route('air-transports.index')->withSuccess(__('main.air_transport_created_successfully'));
        } catch (\Exception $e) {
            return back()->withError(__('main.error_occurred'))->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AirTransport $airTransport)
    {
        $airTransport->load(['region', 'subregion', 'country', 'state', 'city', 'creator', 'updater']);
        return view('pages.dashboard.air-transports.show', compact('airTransport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $airTransport = AirTransport::find($id);
        if (!$airTransport) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.air_transport')]));
        }
        $airTransportTypes = array_keys(config('helpers.air_transport_types'));
        $airTransportStatuses = array_keys(config('helpers.air_transport_statuses'));
        $airTransportServiceTypes = array_keys(config('helpers.air_transport_service_types'));
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.air-transports.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AirTransportUpdateRequest $request, AirTransport $airTransport)
    {
        try {
            $data = $request->validated();
            // Handle JSON fields
            $jsonFields = ['aircraft_types', 'certifications', 'destinations', 'services', 'cabin_classes', 'partnerships', 'codeshare_agreements'];
            foreach ($jsonFields as $field) {
                if (isset($data[$field]) && is_string($data[$field])) {
                    $data[$field] = explode(',', $data[$field]);
                    $data[$field] = array_map('trim', $data[$field]);
                    $data[$field] = array_filter($data[$field]);
                }
            }
            // Set updated_by
            $data['updated_by'] = auth()->id();
            $airTransport->update($data);
            return redirect()->route('air-transports.index')->withSuccess(__('main.air_transport_updated_successfully'));
        } catch (\Exception $e) {
            return back()->withError(__('main.error_occurred'))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $airTransport = AirTransport::find($id);
        if (!$airTransport) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.air_transport')]));
        }
        $deleted = $airTransport->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('main.messages.type_deleted', ['type' => __('main.air_transport')]));
        }
        return redirect()->back()->withError(__('main.messages.type_deletion_failed', ['type' => __('main.air_transport')]));
    }

    /**
     * Display air transports by type
     */
    public function type($type)
    {
        $type = singularLowerCaseName($type, '_');
        $validTypes = config('helpers.air_transport_types');
        if (!isset($validTypes[$type])) {
            return redirect()->route('air-transports.index')->withError(__('main.messages.invalid_type'));
        }
        $typeValue = $validTypes[$type];
        $typeLabel = ucfirst(str_replace('_', ' ', $typeValue));
        return view('pages.dashboard.air-transports.type', get_defined_vars());
    }
}