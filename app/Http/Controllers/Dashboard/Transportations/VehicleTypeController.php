<?php

namespace App\Http\Controllers\Dashboard\Transportations;

use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;
use App\Models\TransportationVehicleType;
use App\Http\Requests\Transportation\VehicleType\StoreRequest;
use App\Http\Requests\Transportation\VehicleType\UpdateRequest;

class VehicleTypeController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportations.vehicle-types.index');
    }

    public function create()
    {
        $companies = TransportationCompany::orderBy('name')->get();
        return view('pages.dashboard.transportations.vehicle-types.create', compact('companies'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $vehicleType = TransportationVehicleType::create($data);
        if (!$vehicleType)
            return redirect()->route('transportations.vehicle-types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportation-vehicle-type')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportation-vehicle-type')]))
            : redirect()->route('transportations.vehicle-types.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportation-vehicle-type')]));
    }

    public function show($id)
    {
        $vehicleType = TransportationVehicleType::with((new TransportationVehicleType())->getRelationshipNames())->find($id);
        if (!$vehicleType)
            return redirect()->route('transportations.vehicle-types.index')->withError(__('messages.type_not_found', ['type' => __('main.transportation-vehicle-type')]));
        return view('pages.dashboard.transportations.vehicle-types.show', compact('vehicleType'));
    }

    public function edit($id)
    {
        $vehicleType = TransportationVehicleType::find($id);
        if (!$vehicleType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-vehicle-type')]));
        $companies = TransportationCompany::orderBy('name')->get();
        return view('pages.dashboard.transportations.vehicle-types.edit', compact('companies', 'vehicleType'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $vehicleType = TransportationVehicleType::find($id);
        if (!$vehicleType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-vehicle-type')]));
        $data = $request->validated();
        $updated = $vehicleType->update($data);
        return $updated
            ? redirect()->route('transportations.vehicle-types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportation-vehicle-type')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportation-vehicle-type')]));
    }

    public function destroy($id)
    {
        $vehicleType = TransportationVehicleType::find($id);
        if (!$vehicleType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-vehicle-type')]));
        $deleted = $vehicleType->delete();
        return $deleted
            ? redirect()->route('transportations.vehicle-types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportation-vehicle-type')]))
            : redirect()->route('transportations.vehicle-types.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportation-vehicle-type')]));
    }
}