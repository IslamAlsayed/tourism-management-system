<?php

namespace Modules\Transportation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Transportation\Entities\Company;
use Modules\Transportation\Entities\VehicleType;
use Modules\Transportation\Http\Requests\VehicleType\StoreRequest;
use Modules\Transportation\Http\Requests\VehicleType\UpdateRequest;

class VehicleTypeController extends Controller
{
    public function index()
    {
        return view('transportation::vehicle-types.index');
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('transportation::vehicle-types.create', compact('companies'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $vehicleType = VehicleType::create($data);
        if (!$vehicleType)
            return redirect()->route('transportation.vehicle-types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportation-vehicle-type')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportation-vehicle-type')]))
            : redirect()->route('transportation.vehicle-types.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportation-vehicle-type')]));
    }

    public function show($id)
    {
        $vehicleType = VehicleType::with((new VehicleType())->getRelationshipNames())->find($id);
        if (!$vehicleType)
            return redirect()->route('transportation.vehicle-types.index')->withError(__('messages.type_not_found', ['type' => __('main.transportation-vehicle-type')]));
        return view('transportation::vehicle-types.show', compact('vehicleType'));
    }

    public function edit($id)
    {
        $vehicleType = VehicleType::find($id);
        if (!$vehicleType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-vehicle-type')]));
        $companies = Company::orderBy('name')->get();
        return view('transportation::vehicle-types.edit', compact('companies', 'vehicleType'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $vehicleType = VehicleType::find($id);
        if (!$vehicleType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-vehicle-type')]));
        $data = $request->validated();
        $updated = $vehicleType->update($data);
        return $updated
            ? redirect()->route('transportation.vehicle-types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportation-vehicle-type')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportation-vehicle-type')]));
    }

    public function destroy($id)
    {
        $vehicleType = VehicleType::find($id);
        if (!$vehicleType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-vehicle-type')]));
        $deleted = $vehicleType->delete();
        return $deleted
            ? redirect()->route('transportation.vehicle-types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportation-vehicle-type')]))
            : redirect()->route('transportation.vehicle-types.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportation-vehicle-type')]));
    }
}
