<?php

namespace Modules\Restaurants\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Restaurants\Entities\Restaurant;
use Modules\Restaurants\Entities\RestaurantSupplement;
use Modules\Restaurants\Http\Requests\Supplement\StoreRequest;
use Modules\Restaurants\Http\Requests\Supplement\UpdateRequest;

class RestaurantSupplementController extends Controller
{
    public function index()
    {
        return view('restaurants::supplements.index');
    }

    public function create()
    {
        $restaurants = Restaurant::all()->pluck('name', 'id');
        return view('restaurants::supplements.create', compact('restaurants'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = RestaurantSupplement::create($validated);

        if ($created && $request->has('custom_fields')) {
            $created->saveCustomFields($request->custom_fields);
        }

        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.supplement')]))
                : redirect()->route('dashboard.restaurants.supplements.index')->with('success', __('messages.type_created', ['type' => __('main.supplement')])))
            : redirect()->route('dashboard.restaurants.supplements.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.supplement')]));
    }

    public function show($id)
    {
        $supplement = RestaurantSupplement::with((new RestaurantSupplement)->getRelationshipNames())->find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        return view('restaurants::supplements.show', compact('supplement'));
    }

    public function edit($id)
    {
        $supplement = RestaurantSupplement::find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        $restaurants = Restaurant::all()->pluck('name', 'id');
        return view('restaurants::supplements.edit', compact('supplement', 'restaurants'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $supplement = RestaurantSupplement::find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        $validated = $request->validated();
        $updated = $supplement->update($validated);

        if ($supplement && $request->has('custom_fields')) {
            $supplement->saveCustomFields($request->custom_fields);
        }

        return $updated
            ? redirect()->route('dashboard.restaurants.supplements.index')->withSuccess(__('messages.type_updated', ['type' => __('main.supplement')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.supplement')]));
    }

    public function destroy($id)
    {
        $supplement = RestaurantSupplement::find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        $deleted = $supplement->delete();
        return $deleted
            ? redirect()->route('dashboard.restaurants.supplements.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.supplement')]))
            : redirect()->route('dashboard.restaurants.supplements.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.supplement')]));
    }
}
