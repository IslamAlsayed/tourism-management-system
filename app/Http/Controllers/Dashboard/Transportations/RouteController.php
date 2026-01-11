<?php

namespace App\Http\Controllers\Dashboard\Transportations;

use App\Models\City;
use App\Models\TransportationRoute;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transportation\Route\StoreRequest;
use App\Http\Requests\Transportation\Route\UpdateRequest;

class RouteController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportations.routes.index');
    }

    public function create()
    {
        return view('pages.dashboard.transportations.routes.create');
    }

    public function getCities()
    {
        $search = request()->input('q', '');
        $page = request()->input('page', 1);
        $perPage = 50;

        $query = City::query()->select('id', 'name')->orderBy('name');

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        $total = $query->count();
        $cities = $query->skip(($page - 1) * $perPage)->take($perPage)->get()
            ->map(fn($city) => ['id' => $city->id, 'text' => $city->name]);

        return response()->json(['results' => $cities, 'pagination' => ['more' => ($page * $perPage) < $total]]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $created = TransportationRoute::create($data);
        if (!$created)
            return redirect()->route('transportations.routes.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportations-route')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route')]))
            : redirect()->route('transportations.routes.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportations-route')]));
    }

    public function show($id)
    {
        $route = TransportationRoute::with((new TransportationRoute())->getRelationshipNames())->find($id);
        if (!$route)
            return redirect()->route('transportations.routes.index')->withError(__('messages.type_not_found', ['type' => __('main.transportations-route')]));
        return view('pages.dashboard.transportations.routes.show', compact('route'));
    }

    public function edit($id)
    {
        $route = TransportationRoute::find($id);
        if (!$route)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route')]));
        return view('pages.dashboard.transportations.routes.edit', compact('route'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $route = TransportationRoute::find($id);
        if (!$route)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route')]));
        $data = $request->validated();
        $updated = $route->update($data);
        return $updated
            ? redirect()->route('transportations.routes.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportations-route')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportations-route')]));
    }

    public function destroy($id)
    {
        $route = TransportationRoute::find($id);
        if (!$route)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-route')]));
        $deleted = $route->delete();
        return $deleted
            ? redirect()->route('transportations.routes.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportations-route')]))
            : redirect()->route('transportations.routes.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportations-route')]));
    }
}