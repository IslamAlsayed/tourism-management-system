<?php

namespace Modules\Restaurants\Http\Controllers;

use App\Http\Requests\Restaurant\StoreRequest;
use App\Http\Requests\Restaurant\UpdateRequest;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Entities\Type;
use Modules\Restaurants\Contracts\RestaurantServiceInterface;
use Modules\Restaurants\Entities\Restaurant;

class RestaurantController extends Controller
{
    use PhotoUploadTrait;

    protected $restaurantService;

    public function __construct(RestaurantServiceInterface $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index()
    {
        return view('restaurants::restaurants.index');
    }

    public function create()
    {
        $types = Type::all()->pluck('name', 'id');
        return view('restaurants::restaurants.create', compact('types'));
    }

    public function store(StoreRequest $request)
    {
        $restaurant = $this->restaurantService->createRestaurant($request->validated());
        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $restaurant, 'photo', 'restaurants');
        }
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]))
            : redirect()->route('dashboard.restaurants.index')->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
    }

    public function show($id)
    {
        $restaurant = $this->restaurantService->getRestaurantById($id);
        if (!$restaurant)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        return view('restaurants::restaurants.show', compact('restaurant'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::with((new Restaurant())->getRelationshipNames())->find($id);
        if (!$restaurant)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        $types = Type::all()->pluck('name', 'id');
        return view('restaurants::restaurants.edit', compact('restaurant', 'types'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $restaurant = $this->restaurantService->getRestaurantById($id);
        if (!$restaurant) {
            return redirect()->route('dashboard.restaurants.index')->withError(__('messages.type_not_found', ['type' => __('main.restaurant')]));
        }
        $updated = $this->restaurantService->updateRestaurant($id, $request->validated());
        if ($request->input('remove_photo') && $request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $restaurant, 'photo', 'restaurants');
        }
        return $updated
            ? redirect()->route('dashboard.restaurants.index')->withSuccess(__('messages.type_updated', ['type' => __('main.restaurant')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.restaurant')]));
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        $deleted = $restaurant->delete();
        return $deleted
            ? redirect()->route('dashboard.restaurants.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.restaurant')]))
            : redirect()->route('dashboard.restaurants.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.restaurant')]));
    }
}
