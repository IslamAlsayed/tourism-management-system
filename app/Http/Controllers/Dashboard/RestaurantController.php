<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Type;
use App\Models\Region;
use App\Models\Restaurant;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\RestaurantCreateRequest;
use App\Http\Requests\Restaurant\RestaurantUpdateRequest;

class RestaurantController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.restaurants.index');
    }

    public function create()
    {
        $types = Type::all()->pluck('name', 'id');
        $regions = Region::all();
        return view('pages.dashboard.restaurants.create', compact('types', 'regions'));
    }

    public function store(RestaurantCreateRequest $request)
    {
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except('photo'));
        $restaurant = Restaurant::create($data);
        if ($restaurant) {
            $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
            }
            return redirect()->route('restaurants.index')->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
        }
        return redirect()->route('restaurants.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
    }

    public function show($id)
    {
        $restaurant = Restaurant::with(['type', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        return view('pages.dashboard.restaurants.show', compact('restaurant'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $types = Type::all()->pluck('name', 'id');
        $regions = Region::all();
        return view('pages.dashboard.restaurants.edit', compact('restaurant', 'types', 'regions'));
    }

    public function update(RestaurantUpdateRequest $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }

        $data = $request->validated();
        if ($request['state_id']) {
            $data['state_id'] = array_unique($data['state_id']);
        }
        if ($request['city_id']) {
            $data['city_id'] = array_unique($data['city_id']);
        }

        $data = array_merge($data, $request->safe()->except('photo'));
        $updated = $restaurant->update($data);
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');
        }
        if ($updated) {
            return redirect()->route('restaurants.index')->withSuccess(__('messages.type_updated', ['type' => __('main.restaurant')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.restaurant')]));
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $deleted = $restaurant->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.restaurant')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.restaurant')]));
    }
}