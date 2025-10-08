<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\Type;
use App\Models\Region;
use App\Models\Country;
use App\Models\Subregion;
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
        $countries = Country::all();
        // $cities = City::limit(15)->get();
        $regions = Region::all();
        $subregions = Subregion::all();
        $types = Type::all()->pluck('name', 'id');

        // return view('pages.dashboard.restaurants.create', compact('types', 'countries', 'cities', 'regions', 'subregions'));
        return view('pages.dashboard.restaurants.create', compact('types', 'countries', 'regions', 'subregions'));
    }

    public function store(RestaurantCreateRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->except('photo');

        $restaurant = Restaurant::create($validated);

        if ($restaurant) {
            $this->uploadPhoto($request, $restaurant, 'photo', "restaurants");
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.restaurant')]));
            }
            return redirect()->route('restaurants.index')->with('success', __('main.messages.type_created', ['type' => __('main.restaurant')]));
        }

        return redirect()->route('restaurants.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.restaurant')]));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $countries = Country::all();
        $cities = City::limit(15)->get();
        $regions = Region::all();
        $subregions = Subregion::all();
        $types = Type::all()->pluck('name', 'id');

        return view('pages.dashboard.restaurants.edit', compact('restaurant', 'types', 'countries', 'cities', 'regions', 'subregions'));
    }

    public function update(RestaurantUpdateRequest $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $validated = $request->validated();
        $validated = $request->safe()->except('photo');

        $this->uploadPhoto($request, $restaurant, 'photo', "restaurants");

        $updated = $restaurant->update($validated);

        if ($updated) {
            return redirect()->route('restaurants.index')->with('success', __('main.messages.type_updated', ['type' => __('main.restaurant')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.restaurant')]));
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $deleted = $restaurant->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.restaurant')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.restaurant')]));
    }

    // public function getCities($countryId)
    // {
    //     if (!$countryId)
    //         return response()->json([]);

    //     $cities = City::where('country_id', $countryId)->select('id', 'name')->orderBy('name')->get();

    //     if ($cities->isEmpty())
    //         return response()->json([]);

    //     return response()->json($cities);
    // }
}