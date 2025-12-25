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
        return view('pages.dashboard.restaurants.create', compact('regions', 'currencies', 'timezones', 'types', 'seasons', 'meals', 'supplements'));
    }

    public function store(StoreRequest $request)
    {
        // dd($request->all(), $request->validated());
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except(['photo', 'seasons', 'meals', 'supplements']));
        $restaurant = Restaurant::create($data);

        if (!$restaurant) {
            return redirect()->route('restaurants.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
        }

        $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');

        if (!empty($validated['seasons'])) {
            foreach ($validated['seasons'] as $seasonData) {

                $season = Season::create([
                    'name' => $seasonData['name'],
                    'name_ar' => $seasonData['name_ar'] ?? null,
                    'season_from' => $seasonData['season_from'],
                    'season_to' => $seasonData['season_to'],
                    'notes' => $seasonData['notes'] ?? null,
                    'is_active' => $seasonData['is_active'] ?? true,
                ]);

                $restaurant->seasons()->attach($season->id, [
                    'price' => $seasonData['price'] ?? null,
                ]);
            }
        }

        if (!empty($validated['meals'])) {
            foreach ($validated['meals'] as $mealData) {

                $meal = Meal::create([
                    'name' => $mealData['name'],
                    'name_ar' => $mealData['name_ar'] ?? null,
                    'currency_id' => $mealData['currency_id'],
                    'price' => $mealData['price'],
                    'is_included' => $mealData['is_included'] ?? false,
                    'is_supplement' => $mealData['is_supplement'] ?? false,
                    'is_active' => $mealData['is_active'] ?? true,
                    'notes' => $mealData['notes'] ?? null,
                ]);

                $restaurant->meals()->attach($meal->id, [
                    'price' => $mealData['price'],
                ]);
            }
        }

        if (!empty($validated['supplements'])) {
            foreach ($validated['supplements'] as $supplementData) {

                $supplement = Supplement::create([
                    'name' => $supplementData['name'],
                    'name_ar' => $supplementData['name_ar'] ?? null,
                    'currency_id' => $supplementData['currency_id'],
                    'price' => $supplementData['price'],
                    'price_type' => $supplementData['price_type'] ?? 'one_time',
                    'is_mandatory' => $supplementData['is_mandatory'] ?? false,
                    'is_active' => $supplementData['is_active'] ?? true,
                    'notes' => $supplementData['notes'] ?? null,
                ]);

                $restaurant->supplements()->attach($supplement->id, [
                    'price' => $supplementData['price'],
                ]);
            }
        }

        if ($request->has('save_and_add')) {
            return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
        }
        return redirect()->route('restaurants.index')->withSuccess(__('messages.type_created', ['type' => __('main.restaurant')]));
    }

    public function show($id)
    {
        $restaurant = Restaurant::with(['type', 'region', 'subregion', 'country', 'state', 'city', 'seasons', 'meals', 'supplements'])->find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        return view('pages.dashboard.restaurants.show', compact('restaurant'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::with(['seasons', 'meals', 'supplements'])->find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $regions = Region::all();
        $currencies = Currency::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        $types = Type::all()->pluck('name', 'id');

        // Get all available seasons/meals/supplements for selection
        $availableSeasons = Season::orderBy('name')->get();
        $seasonsSelected = $restaurant->seasons->map(function ($season) {
            return [
                'id' => $season->id,
                'name' => $season->name,
                'price' => $season->pivot->price ?? 0
            ];
        })->toArray();

        $availableMeals = Meal::orderBy('name')->get();
        $mealsSelected = $restaurant->meals->map(function ($meal) {
            return [
                'id' => $meal->id,
                'name' => $meal->name,
                'price' => $meal->pivot->price ?? 0
            ];
        })->toArray();

        $availableSupplements = Supplement::orderBy('name')->get();
        $supplementsSelected = $restaurant->supplements->map(function ($supplement) {
            return [
                'id' => $supplement->id,
                'name' => $supplement->name,
                'price' => $supplement->pivot->price ?? 0
            ];
        })->toArray();

        return view('pages.dashboard.restaurants.edit', compact('restaurant', 'regions', 'currencies', 'timezones', 'types', 'availableSeasons', 'seasonsSelected', 'availableMeals', 'mealsSelected', 'availableSupplements', 'supplementsSelected'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.restaurant')]));
        }
        $data = $request->validated();
        $data = array_merge($data, $request->safe()->except(['photo', 'seasons', 'meals', 'supplements']));
        $updated = $restaurant->update($data);

        if ($request->has('photo')) {
            $this->uploadPhoto($request, $restaurant, 'photo', 'restaurants');
        }

        // Sync seasons with price in pivot table
        if (isset($data['seasons']) && is_array($data['seasons'])) {
            $seasonsToSync = [];
            foreach ($data['seasons'] as $season) {
                if (isset($season['season_id']) && isset($season['price'])) {
                    $seasonsToSync[$season['season_id']] = ['price' => $season['price']];
                }
            }
            $restaurant->seasons()->sync($seasonsToSync);
        } else {
            $restaurant->seasons()->sync([]);
        }

        // Sync meals with price in pivot table
        if (isset($data['meals']) && is_array($data['meals'])) {
            $mealsToSync = [];
            foreach ($data['meals'] as $meal) {
                if (isset($meal['meal_id']) && isset($meal['price'])) {
                    $mealsToSync[$meal['meal_id']] = ['price' => $meal['price']];
                }
            }
            $restaurant->meals()->sync($mealsToSync);
        } else {
            $restaurant->meals()->sync([]);
        }

        // Sync supplements with price in pivot table
        if (isset($data['supplements']) && is_array($data['supplements'])) {
            $supplementsToSync = [];
            foreach ($data['supplements'] as $supplement) {
                if (isset($supplement['supplement_id']) && isset($supplement['price'])) {
                    $supplementsToSync[$supplement['supplement_id']] = ['price' => $supplement['price']];
                }
            }
            $restaurant->supplements()->sync($supplementsToSync);
        } else {
            $restaurant->supplements()->sync([]);
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