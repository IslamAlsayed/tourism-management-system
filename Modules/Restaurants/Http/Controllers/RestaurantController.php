<?php

namespace Modules\Restaurants\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\Subregion;
use Modules\Accommodations\Entities\Season;
use Modules\Restaurants\Entities\Restaurant;
use Modules\Restaurants\Entities\RestaurantType;
use App\Http\Requests\Restaurant\StoreRequest;
use App\Http\Requests\Restaurant\UpdateRequest;

class RestaurantController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('restaurants::restaurants.index');
    }

    public function create()
    {
        $types = RestaurantType::where('is_active', true)->pluck('name', 'id');
        $regions = Region::orderBy('name')->pluck('name', 'id');
        $subregions = Subregion::orderBy('name')->pluck('name', 'id');
        return view('restaurants::restaurants.create', compact('types', 'regions', 'subregions'));
    }

    public function store(StoreRequest $request)
    {
        \Log::info('Restaurant Store Payload: ', $request->all());
        $validated = $request->validated();
        \Log::info('Restaurant Validated Payload: ', $validated);
        $validated = array_merge($validated, $request->safe()->except(['photo', 'seasons']));
        $restaurant = Restaurant::create($validated);
        if (!$restaurant)
            return redirect()->route('dashboard.restaurants.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
        $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');

        if ($restaurant && $request->has('custom_fields')) {
            $restaurant->saveCustomFields($request->custom_fields);
        }
        // CREATE SEASONS
        $seasonIdMap = [];
        if (!empty($validated['seasons'])) {
            foreach ($validated['seasons'] as $seasonData) {
                $seasonData['model_id'] = $restaurant->id;
                $seasonData['model_type'] = Restaurant::class;
                $tempId = $seasonData['id'] ?? null;
                unset($seasonData['id']); // Prevent attempting to insert string temp ID

                $season = Season::create($seasonData);
                if ($tempId) {
                    $seasonIdMap[$tempId] = $season->id;
                }
            }
        }

        // CREATE MEALS
        if (!empty($validated['meals'])) {
            foreach ($validated['meals'] as $mealData) {
                $mealData['restaurant_id'] = $restaurant->id;
                unset($mealData['id']); // Remove temp ID
                
                // Swap temporary season ID for real database ID if we just created it
                if (!empty($mealData['season_id']) && isset($seasonIdMap[$mealData['season_id']])) {
                    $mealData['season_id'] = $seasonIdMap[$mealData['season_id']];
                }
                
                RestaurantMeal::create($mealData);
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
        $types = RestaurantType::where('is_active', true)->pluck('name', 'id');
        $regions = Region::orderBy('name')->pluck('name', 'id');
        $subregions = Subregion::orderBy('name')->pluck('name', 'id');
        return view('restaurants::restaurants.edit', compact('restaurant', 'types', 'regions', 'subregions'));
    }

    public function update(UpdateRequest $request, $id)
    {
        \Log::info('Restaurant Update Payload: ', $request->all());
        $restaurant = Restaurant::find($id);
        if (!$restaurant)
            return redirect()->route('dashboard.restaurants.index')->withError(__('messages.type_not_found', ['type' => __('main.restaurant')]));
        $validated = $request->validated();
        $validated = array_merge($validated, $request->safe()->except(['photo', 'seasons']));
        $updated = $restaurant->update($validated);
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');
        }

        if ($restaurant && $request->has('custom_fields')) {
            $restaurant->saveCustomFields($request->custom_fields);
        }
        // EDIT SEASONS
        $existingSeasonIds = [];
        $seasonIdMap = [];
        if (!empty($validated['seasons'])) {
            foreach ($validated['seasons'] as $seasonData) {
                $seasonData['model_id'] = $restaurant->id;
                $seasonData['model_type'] = Restaurant::class;
                
                if (!empty($seasonData['id']) && is_numeric($seasonData['id'])) {
                    $season = Season::find($seasonData['id']);
                    if ($season) {
                        $season->update($seasonData);
                        $existingSeasonIds[] = $season->id;
                    }
                } else {
                    $tempId = $seasonData['id'] ?? null;
                    unset($seasonData['id']);
                    $season = Season::create($seasonData);
                    $existingSeasonIds[] = $season->id;
                    if ($tempId) {
                        $seasonIdMap[$tempId] = $season->id;
                    }
                }
            }
            $restaurant->seasons()->where('model_type', Restaurant::class)
                ->where('model_id', $restaurant->id)
                ->whereNotIn('id', $existingSeasonIds)->delete();
        } else {
            $restaurant->seasons()->where('model_type', Restaurant::class)
                ->where('model_id', $restaurant->id)->delete();
        }

        // EDIT MEALS
        $existingMealIds = [];
        if (!empty($validated['meals'])) {
            foreach ($validated['meals'] as $mealData) {
                $mealData['restaurant_id'] = $restaurant->id;
                
                if (!empty($mealData['season_id']) && isset($seasonIdMap[$mealData['season_id']])) {
                    $mealData['season_id'] = $seasonIdMap[$mealData['season_id']];
                }
                
                if (!empty($mealData['id']) && is_numeric($mealData['id'])) {
                    $meal = RestaurantMeal::find($mealData['id']);
                    if ($meal) {
                        $meal->update($mealData);
                        $existingMealIds[] = $meal->id;
                    }
                } else {
                    unset($mealData['id']);
                    $meal = RestaurantMeal::create($mealData);
                    $existingMealIds[] = $meal->id;
                }
            }
            $restaurant->meals()->whereNotIn('id', $existingMealIds)->delete();
        } else {
            $restaurant->meals()->delete();
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
