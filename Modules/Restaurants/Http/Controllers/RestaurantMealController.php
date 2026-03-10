<?php

namespace Modules\Restaurants\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Restaurants\Entities\Restaurant;
use Modules\Restaurants\Entities\RestaurantMeal;
use Modules\Restaurants\Http\Requests\Meal\StoreRequest;
use Modules\Restaurants\Http\Requests\Meal\UpdateRequest;
use Modules\Restaurants\Entities\RestaurantType;
use Modules\Accommodations\Entities\Season;
use Modules\Localization\Entities\Currency;

class RestaurantMealController extends Controller
{
    public function index()
    {
        return view('restaurants::meals.index');
    }

    public function create()
    {
        $restaurants = Restaurant::all();
        $currencies = Currency::pluck('code', 'id')->toArray();
        $seasons = Season::where('model_type', Restaurant::class)->get();
        return view('restaurants::meals.create', compact('restaurants', 'currencies', 'seasons'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        
        $created = false;
        
        if (isset($validated['meals']) && is_array($validated['meals'])) {
            // New bulk format (multiple meals in one request)
            foreach ($validated['meals'] as $mealData) {
                // Ensure the base restaurant_id is injected into each meal
                $mealData['restaurant_id'] = $validated['restaurant_id'];
                
                $meal = RestaurantMeal::create($mealData);
                if ($meal) {
                    $created = true;
                    if ($request->has('custom_fields')) {
                        $meal->saveCustomFields($request->custom_fields);
                    }
                }
            }
        } else {
            // Fallback for singular format
            $createdRecord = RestaurantMeal::create($validated);
            if ($createdRecord) {
                $created = true;
                if ($request->has('custom_fields')) {
                    $createdRecord->saveCustomFields($request->custom_fields);
                }
            }
        }

        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.meals')]))
                : redirect()->route('dashboard.restaurants.meals.index')->with('success', __('messages.type_created', ['type' => __('main.meals')])))
            : redirect()->route('dashboard.restaurants.meals.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.meals')]));
    }

    public function show($id)
    {
        $meal = RestaurantMeal::with((new RestaurantMeal)->getRelationshipNames())->find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        return view('restaurants::meals.show', compact('meal'));
    }

    public function edit($id)
    {
        $meal = RestaurantMeal::with((new RestaurantMeal())->getRelationshipNames())->find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        $restaurants = Restaurant::all();
        $currencies = Currency::pluck('code', 'id')->toArray();
        $seasons = Season::where('model_type', Restaurant::class)->get();
        return view('restaurants::meals.edit', compact('meal', 'restaurants', 'currencies', 'seasons'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $meal = RestaurantMeal::find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        $validated = $request->validated();
        $updated = $meal->update($validated);

        if ($meal && $request->has('custom_fields')) {
            $meal->saveCustomFields($request->custom_fields);
        }

        return $updated
            ? redirect()->route('dashboard.restaurants.meals.index')->withSuccess(__('messages.type_updated', ['type' => __('main.meal')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.meal')]));
    }

    public function destroy($id)
    {
        $meal = RestaurantMeal::find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        $deleted = $meal->delete();
        return $deleted
            ? redirect()->route('dashboard.restaurants.meals.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.meal')]))
            : redirect()->route('dashboard.restaurants.meals.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.meal')]));
    }
}
