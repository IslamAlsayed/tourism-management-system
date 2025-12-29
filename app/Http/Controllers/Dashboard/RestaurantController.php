<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Meal;
use App\Models\Type;
use App\Models\Region;
use App\Models\Season;
use App\Models\Currency;
use App\Models\Timezone;
use App\Models\Restaurant;
use App\Models\Supplement;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\StoreRequest;
use App\Http\Requests\Restaurant\UpdateRequest;

class RestaurantController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.restaurants.index');
    }

    public function create()
    {
        $regions = Region::all();
        $currencies = Currency::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        $types = Type::all()->pluck('name', 'id');
        $seasons = Season::orderBy('name')->get();
        $meals = Meal::orderBy('name')->get();
        $supplements = Supplement::orderBy('name')->get();
        return view('pages.dashboard.restaurants.create', get_defined_vars());
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated = array_merge($validated, $request->safe()->except(['photo', 'seasons', 'meals', 'supplements']));
        $restaurant = Restaurant::create($validated);

        if (!$restaurant) {
            return redirect()->route('restaurants.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
        }

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

        if ($request->has('save_and_add')) {
            return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
        }
        return redirect()->route('restaurants.index')->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
    }

    public function show($id)
    {
        $restaurant = Restaurant::with((new Restaurant())->getRelationshipNames())->find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        return view('pages.dashboard.restaurants.show', compact('restaurant'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::with((new Restaurant())->getRelationshipNames())->find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $regions = Region::all();
        $currencies = Currency::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        $types = Type::all()->pluck('name', 'id');
        return view('pages.dashboard.restaurants.edit', get_defined_vars());
    }

    public function update(UpdateRequest $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->route('restaurants.index')->withError(__('messages.type_not_found', ['type' => __('main.restaurant')]));
        }

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
            return redirect()->route('restaurants.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.restaurant')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.restaurant')]));
    }
}