<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\Type;
use App\Models\Region;
use App\Models\Country;
use App\Models\Subregion;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\RestaurantCreateRequest;
use App\Http\Requests\Restaurant\RestaurantUpdateRequest;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with(['country', 'city'])->paginate(getPaginate());
        $total = Restaurant::count();
        return view('pages.dashboard.restaurants.index', compact('restaurants', 'total'));
    }

    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        $regions = Region::all();
        $subregions = Subregion::all();
        $types = Type::all();

        return view('pages.dashboard.restaurants.create', compact('countries', 'cities', 'regions', 'subregions', 'types'));
    }

    public function store(RestaurantCreateRequest $request)
    {
        $validated = $request->validated();

        $restaurant = Restaurant::create($validated);

        if ($restaurant) {
            return redirect()->route('restaurants.index')->with('success', __('main.messages.restaurant_created'));
        }

        return redirect()->route('restaurants.index')->with('error', __('main.messages.restaurant_creation_failed'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $countries = Country::all();
        $cities = City::all();
        $regions = Region::all();
        $subregions = Subregion::all();
        $types = Type::all();

        return view('pages.dashboard.restaurants.edit', compact('restaurant', 'countries', 'cities', 'regions', 'subregions', 'types'));
    }

    public function update(RestaurantUpdateRequest $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $validated = $request->validated();

        $restaurant->update($validated);

        return redirect()->route('restaurants.index')->with('success', __('main.messages.restaurant_updated'));
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $deleted = $restaurant->delete();
        if ($deleted) {
            return redirect()->route('restaurants.index')->with('success', __('main.messages.restaurant_deleted'));
        }

        return redirect()->route('restaurants.index')->with('error', __('main.messages.restaurant_deletion_failed'));
    }
}