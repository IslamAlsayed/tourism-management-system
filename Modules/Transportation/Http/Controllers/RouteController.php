<?php

namespace Modules\Transportation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Transportation\Entities\Route;
use App\Http\Requests\Transportation\Route\StoreRequest;
use App\Http\Requests\Transportation\Route\UpdateRequest;

class RouteController extends Controller
{
    public function index()
    {
        return view('transportation::routes.index');
    }

    public function create()
    {
        return view('transportation::routes.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $created = Route::create($data);
        if (!$created)
            return redirect()->route('transportation.routes.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportations-route')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route')]))
            : redirect()->route('transportation.routes.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route')]));
    }

    public function show($id)
    {
        $route = Route::with((new Route())->getRelationshipNames())->find($id);
        if (!$route)
            return redirect()->route('transportation.routes.index')->withError(__('messages.type_not_found', ['type' => __('main.transportations-route')]));
        return view('transportation::routes.show', compact('route'));
    }

    public function edit($id)
    {
        $route = Route::find($id);
        if (!$route)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route')]));
        return view('transportation::routes.edit', compact('route'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $route = Route::find($id);
        if (!$route)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route')]));
        $data = $request->validated();
        $updated = $route->update($data);
        return $updated
            ? redirect()->route('transportation.routes.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportations-route')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportations-route')]));
    }

    public function destroy($id)
    {
        $route = Route::find($id);
        if (!$route)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route')]));
        $deleted = $route->delete();
        return $deleted
            ? redirect()->route('transportation.routes.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportations-route')]))
            : redirect()->route('transportation.routes.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportations-route')]));
    }
}
