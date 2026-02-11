<?php

namespace Modules\Restaurants\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Entities\Meal;
use Modules\Accommodations\Entities\Type;
use Modules\Accommodations\Entities\Season;
use Modules\Restaurants\Entities\Restaurant;
use App\Http\Requests\Restaurant\StoreRequest;
use App\Http\Requests\Restaurant\UpdateRequest;
use Modules\Accommodations\Entities\Supplement;

class RestaurantController extends Controller
{
    use PhotoUploadTrait;

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
        $validated = $request->validated();
        $validated = array_merge($validated, $request->safe()->except(['photo', 'seasons', 'meals', 'supplements']));
        $restaurant = Restaurant::create($validated);
        if (!$restaurant)
            return redirect()->route('dashboard.restaurants.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
        $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');
        // CREATE SEASONS
        if (!empty($validated['seasons'])) {
            foreach ($validated['seasons'] as $seasonData) {
                $validated['model_id'] = $restaurant->id;
                $validated['model_type'] = Restaurant::class;
                Season::create($seasonData);
            }
        }
        // CREATE MEALS
        if (!empty($validated['meals'])) {
            foreach ($validated['meals'] as $mealData) {
                $validated['model_id'] = $restaurant->id;
                $validated['model_type'] = Restaurant::class;
                Meal::create($mealData);
            }
        }
        // CREATE SUPPLEMENTS
        if (!empty($validated['supplements'])) {
            foreach ($validated['supplements'] as $supplementData) {
                $validated['model_id'] = $restaurant->id;
                $validated['model_type'] = Restaurant::class;
                Supplement::create($supplementData);
            }
        }
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]))
            : redirect()->route('dashboard.restaurants.index')->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
    }

    public function show($id)
    {
        $restaurant = Restaurant::with((new Restaurant())->getRelationshipNames())->find($id);
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
        $restaurant = Restaurant::find($id);
        if (!$restaurant)
            return redirect()->route('dashboard.restaurants.index')->withError(__('messages.type_not_found', ['type' => __('main.restaurant')]));
        $validated = $request->validated();
        $validated = array_merge($validated, $request->safe()->except(['photo', 'seasons', 'meals', 'supplements']));
        $updated = $restaurant->update($validated);
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');
        }
        // EDIT SEASONS
        if (!empty($validated['seasons'])) {
            $restaurant->seasons()->where('model_type', Restaurant::class)->where('model_id', $restaurant->id)->delete();
            foreach ($validated['seasons'] as $seasonData) {
                $seasonData['model_id'] = $restaurant->id;
                $seasonData['model_type'] = Restaurant::class;
                Season::create($seasonData);
            }
        }
        // EDIT MEALS
        if (!empty($validated['meals'])) {
            $restaurant->meals()->where('model_type', Restaurant::class)->where('model_id', $restaurant->id)->delete();
            foreach ($validated['meals'] as $mealData) {
                $mealData['model_id'] = $restaurant->id;
                $mealData['model_type'] = Restaurant::class;
                Meal::create($mealData);
            }
        }
        // EDIT SUPPLEMENTS
        if (!empty($validated['supplements'])) {
            $restaurant->supplements()->where('model_type', Restaurant::class)->where('model_id', $restaurant->id)->delete();
            foreach ($validated['supplements'] as $supplementData) {
                $supplementData['model_id'] = $restaurant->id;
                $supplementData['model_type'] = Restaurant::class;
                Supplement::create($supplementData);
            }
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