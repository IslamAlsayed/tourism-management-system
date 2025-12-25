<?php

namespace App\Http\Controllers\Dashboard\Transportation;

use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;
use App\Models\TransportationBusType;
use App\Http\Requests\TransportationBusTypes\TransportationBusTypesCreateRequest;
use App\Http\Requests\TransportationBusTypes\TransportationBusTypesUpdateRequest;

class BusTypeController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportation-bus-types.index');
    }

    public function create()
    {
        $transportationCompanies = TransportationCompany::all();
        return view('pages.dashboard.transportation-bus-types.create', compact('transportationCompanies'));
    }

    public function store(TransportationBusTypesCreateRequest $request)
    {
        $validated = $request->validated();
        $transportationBusTypes = TransportationBusType::create($validated);

        if ($transportationBusTypes) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportation_bus_type')]));
            }
            return redirect()->route('transportation-bus-types.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportation_bus_type')]));
        }

        return redirect()->route('transportation-bus-types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
    }

    public function show($id)
    {
        $transportationBusType = TransportationBusType::with(['transportationCompany'])->find($id);
        if (!$transportationBusType) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_bus_type')]));
        }
        return view('pages.dashboard.transportation-bus-types.show', compact('transportationBusType'));
    }

    public function edit($id)
    {
        $transportationBusType = TransportationBusType::find($id);
        $transportationCompanies = TransportationCompany::all();
        if (!$transportationBusType) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_bus_type')]));
        }
        return view('pages.dashboard.transportation-bus-types.edit', compact('transportationBusType', 'transportationCompanies'));
    }

    public function update(TransportationBusTypesUpdateRequest $request, $id)
    {
        $transportationBusTypes = TransportationBusType::find($id);
        if (!$transportationBusTypes) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_bus_type')]));
        }

        $validated = $request->validated();
        $updated = $transportationBusTypes->update($validated);

        if ($updated) {
            return redirect()->route('transportation-bus-types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportation_bus_type')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportation_bus_type')]));
    }

    public function destroy($id)
    {
        $transportationBusTypes = TransportationBusType::find($id);
        if (!$transportationBusTypes) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_bus_type')]));
        }
        $deleted = $transportationBusTypes->delete();
        if ($deleted) {
            return redirect()->route('transportation-bus-types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportation_bus_type')]));
        }

        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.transportation_bus_type')]));
    }
}