<?php

namespace Modules\Transportation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Transportation\Entities\Route;
use Modules\Transportation\Entities\RouteAssignment;
use App\Http\Requests\Transportation\RouteAssignment\StoreRequest;
use App\Http\Requests\Transportation\RouteAssignment\UpdateRequest;

class RouteAssignmentController extends Controller
{
    public function index()
    {
        return view('transportation::route-assignments.index');
    }

    public function create()
    {
        $routes = Route::with(['originCity:id,name', 'destinationCity:id,name'])->orderBy('name')->get(['id', 'name', 'origin_city_id', 'destination_city_id']);
        return view('transportation::route-assignments.create', compact('routes'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $created = RouteAssignment::create($data);
        if (!$created)
            return redirect()->route('transportation.route-assignments.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportations-route-assignment')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route-assignment')]))
            : redirect()->route('transportation.route-assignments.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route-assignment')]));
    }

    public function show($id)
    {
        $assignment = RouteAssignment::with((new RouteAssignment())->getRelationshipNames())->find($id);
        if (!$assignment)
            return redirect()->route('transportation.route-assignments.index')->withError(__('messages.type_not_found', ['type' => __('main.transportations-route-assignment')]));
        return view('transportation::route-assignments.show', compact('assignment'));
    }

    public function edit($id)
    {
        $assignment = RouteAssignment::with(['route.originCity', 'route.destinationCity'])->find($id);
        if (!$assignment)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route-assignment')]));
        $routes = Route::with(['originCity:id,name', 'destinationCity:id,name'])->orderBy('name')->get(['id', 'name', 'origin_city_id', 'destination_city_id']);
        return view('transportation::route-assignments.edit', compact('assignment', 'routes'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $assignment = RouteAssignment::find($id);
        if (!$assignment)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route-assignment')]));
        $data = $request->validated();
        $updated = $assignment->update($data);
        return $updated
            ? redirect()->route('transportation.route-assignments.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportations-route-assignment')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportations-route-assignment')]));
    }

    public function destroy($id)
    {
        $assignment = RouteAssignment::find($id);
        if (!$assignment)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route-assignment')]));
        $deleted = $assignment->delete();
        return $deleted
            ? redirect()->route('transportation.route-assignments.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportations-route-assignment')]))
            : redirect()->route('transportation.route-assignments.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportations-route-assignment')]));
    }
}
