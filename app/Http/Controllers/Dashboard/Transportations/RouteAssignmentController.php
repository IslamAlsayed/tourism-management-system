<?php

namespace App\Http\Controllers\Dashboard\Transportations;

use App\Models\TransportationRoute;
use App\Http\Controllers\Controller;
use App\Models\TransportationRouteAssignment;
use App\Http\Requests\Transportation\RouteAssignment\StoreRequest;
use App\Http\Requests\Transportation\RouteAssignment\UpdateRequest;

class RouteAssignmentController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportations.route-assignments.index');
    }

    public function create()
    {
        $routes = TransportationRoute::with(['originCity:id,name', 'destinationCity:id,name'])->orderBy('name')->get(['id', 'name', 'origin_city_id', 'destination_city_id']);
        return view('pages.dashboard.transportations.route-assignments.create', compact('routes'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $created = TransportationRouteAssignment::create($data);
        if (!$created)
            return redirect()->route('transportations.route-assignments.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportations-route-assignment')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route-assignment')]))
            : redirect()->route('transportations.route-assignments.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route-assignment')]));
    }

    public function show($id)
    {
        $assignment = TransportationRouteAssignment::with((new TransportationRouteAssignment())->getRelationshipNames())->find($id);
        if (!$assignment)
            return redirect()->route('transportations.route-assignments.index')->withError(__('messages.type_not_found', ['type' => __('main.transportations-route-assignment')]));
        return view('pages.dashboard.transportations.route-assignments.show', compact('assignment'));
    }

    public function edit($id)
    {
        $assignment = TransportationRouteAssignment::with(['route.originCity', 'route.destinationCity'])->find($id);
        if (!$assignment)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route-assignment')]));
        $routes = TransportationRoute::with(['originCity:id,name', 'destinationCity:id,name'])->orderBy('name')->get(['id', 'name', 'origin_city_id', 'destination_city_id']);
        return view('pages.dashboard.transportations.route-assignments.edit', compact('assignment', 'routes'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $assignment = TransportationRouteAssignment::find($id);
        if (!$assignment)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route-assignment')]));
        $data = $request->validated();
        $updated = $assignment->update($data);
        return $updated
            ? redirect()->route('transportations.route-assignments.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportations-route-assignment')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportations-route-assignment')]));
    }

    public function destroy($id)
    {
        $assignment = TransportationRouteAssignment::find($id);
        if (!$assignment)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route-assignment')]));
        $deleted = $assignment->delete();
        return $deleted
            ? redirect()->route('transportations.route-assignments.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportations-route-assignment')]))
            : redirect()->route('transportations.route-assignments.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportations-route-assignment')]));
    }
}