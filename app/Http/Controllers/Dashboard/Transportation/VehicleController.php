<?php

namespace App\Http\Controllers\Dashboard\Transportation;

use App\Http\Controllers\Controller;
use App\Models\TransportationCarRoutePrice;
use App\Models\TransportationCompany;
use App\Models\TransportationCarRoute;
use App\Models\Currency;
use App\Http\Requests\TransportationCarRoutes\TransportationCarRoutesCreateRequest;
use App\Http\Requests\TransportationCarRoutes\TransportationCarRoutesUpdateRequest;

class VehicleController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportation-vehicles.index');
    }

    public function create()
    {
        $carRoutesPrice = TransportationCarRoutePrice::all();
        $carRoutes = TransportationCarRoute::all();
        $currencies = Currency::all();
        return view('pages.dashboard.transportation-vehicles.create', compact('carRoutesPrice', 'carRoutes','currencies'));
    }

    public function store(transportationCarRoutesCreateRequest $request)
    {
        $validated = $request->validated();
        $transportationCarRoute = TransportationCarRoute::create($validated);
        $transportationCarRoutePrice = TransportationCarRoutePrice::create($validated);

        if ($transportationCarRoute && $transportationCarRoutePrice) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.transportation_vehicle')]));
            }
            return redirect()->route('transportation-vehicles.index')->with('success', __('main.messages.type_created', ['type' => __('main.transportation_vehicle')]));
        }

        return redirect()->route('transportation-vehicles.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.restaurant')]));
    }

    public function edit($id)
    {
        $transportationCarRoute = TransportationCarRoute::with('details')->find($id);
        $carRoutes = TransportationCarRoute::all();
        $currencies = Currency::all();

        if (!$transportationCarRoute) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.transportation_vehicle')]));
        }
        return view('pages.dashboard.transportation-vehicles.edit', compact('transportationCarRoute', 'carRoutes', 'currencies'));
    }

    public function update(transportationCarRoutesUpdateRequest $request, $id)
    {
        $transportationCarRoute = TransportationCarRoute::find($id);
        $transportationCarRoutePrice = TransportationCarRoutePrice::find($id);

        if (!$transportationCarRoute || !$transportationCarRoutePrice) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.transportation_vehicle')]));
        }

        $validated = $request->validated();
        $updated1 = $transportationCarRoute->update($validated);
        $updated2 = $transportationCarRoutePrice->update($validated);

        if ($updated1 && $updated2) {
            return redirect()->route('transportation-vehicles.index')->with('success', __('main.messages.type_updated', ['type' => __('main.transportation_vehicle')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.transportation_vehicle')]));
    }

    public function destroy($id)
    {
        $transportationCarRoute = TransportationCarRoute::find($id);
        if (!$transportationCarRoute) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.transportation_vehicle')]));
        }
        $deleted = $transportationCarRoute->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.transportation_vehicle')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.transportation_vehicle')]));
    }
}