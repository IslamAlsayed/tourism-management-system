<?php

namespace Modules\Restaurants\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Restaurants\Entities\RestaurantType;
use Modules\Restaurants\Http\Requests\Type\StoreRequest;
use Modules\Restaurants\Http\Requests\Type\UpdateRequest;

class RestaurantTypeController extends Controller
{
    public function index()
    {
        return view('restaurants::types.index');
    }

    public function create()
    {
        return view('restaurants::types.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = RestaurantType::create($validated);
        if (!$created)
            return redirect()->route('dashboard.restaurants.types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.type')]));

        if ($created && $request->has('custom_fields')) {
            $created->saveCustomFields($request->custom_fields);
        }
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.type')]))
            : redirect()->route('dashboard.restaurants.types.index')->withSuccess(__('messages.type_created', ['type' => __('main.type')]));
    }

    public function show($id)
    {
        $type = RestaurantType::find($id);
        if (!$type)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        return view('restaurants::types.show', compact('type'));
    }

    public function edit($id)
    {
        $type = RestaurantType::find($id);
        if (!$type)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        return view('restaurants::types.edit', compact('type'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $type = RestaurantType::find($id);
        if (!$type)
            return redirect()->route('dashboard.restaurants.types.index')->withError(__('messages.type_not_found', ['type' => __('main.type')]));
        $validated = $request->validated();
        $updated = $type->update($validated);

        if ($type && $request->has('custom_fields')) {
            $type->saveCustomFields($request->custom_fields);
        }
        return $updated
            ? redirect()->route('dashboard.restaurants.types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.type')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.type')]));
    }

    public function destroy($id)
    {
        $type = RestaurantType::find($id);
        if (!$type)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        $deleted = $type->delete();
        return $deleted
            ? redirect()->route('dashboard.restaurants.types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.type')]))
            : redirect()->route('dashboard.restaurants.types.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.type')]));
    }
}
