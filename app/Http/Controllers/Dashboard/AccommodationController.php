<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Meal;
use App\Models\Room;
use App\Models\Type;
use App\Models\Region;
use App\Models\Season;
use App\Models\Currency;
use App\Models\Timezone;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\StoreRequest;
use App\Http\Requests\Accommodations\UpdateRequest;

class AccommodationController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.accommodations.index');
    }

    public function create()
    {
        $types = Type::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        $meals = Meal::orderBy('name')->get();
        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.accommodations.create', compact('types', 'seasons', 'rooms', 'meals', 'currencies', 'regions', 'timezones'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        // Create accommodation (basic fields only)
        $accommodation = Accommodation::create($request->except(['seasons', 'rooms', 'meals', 'supplements']));

        // Process Seasons
        $seasonIds = [];
        if (!empty($data['seasons']) && is_array($data['seasons'])) {
            foreach ($data['seasons'] as $seasonData) {
                $season = Season::create([
                    'name' => $seasonData['name'],
                    'name_ar' => $seasonData['name_ar'] ?? null,
                    'season_from' => $seasonData['season_from'],
                    'season_to' => $seasonData['season_to'],
                    'is_active' => $seasonData['is_active'] ?? 1,
                    'notes' => $seasonData['notes'] ?? null,
                ]);
                $seasonIds[] = $season->id;
            }
        }

        // Process Rooms
        if (!empty($data['rooms']) && is_array($data['rooms'])) {
            foreach ($data['rooms'] as $roomData) {
                $room = Room::create([
                    'name' => $roomData['name'],
                    'name_ar' => $roomData['name_ar'] ?? null,
                    'max_occupancy' => $roomData['max_occupancy'] ?? null,
                    'occupancy_details' => $roomData['occupancy_details'] ?? null,
                    'is_active' => $roomData['is_active'] ?? 1,
                    'notes' => $roomData['notes'] ?? null,
                ]);

                // Create room rates for each season
                if (!empty($seasonIds)) {
                    foreach ($seasonIds as $seasonId) {
                        $accommodation->roomRates()->create([
                            'season_id' => $seasonId,
                            'room_id' => $room->id,
                            'currency_id' => $roomData['currency_id'],
                            'price_per_person_double' => $roomData['price_per_person_double'],
                            'single_room_supplement' => $roomData['single_room_supplement'] ?? 0,
                            'triple_room_discount' => $roomData['triple_room_discount'] ?? 0,
                            'third_person_price' => $roomData['third_person_price'] ?? 0,
                            'extra_bed_price' => $roomData['extra_bed_price'] ?? 0,
                            'sea_view_supplement' => $roomData['sea_view_supplement'] ?? 0,
                            'is_active' => $roomData['is_active'] ?? 1,
                        ]);
                    }
                }
            }
        }

        // Process Meals
        if (!empty($data['meals']) && is_array($data['meals'])) {
            foreach ($data['meals'] as $mealData) {
                $meal = Meal::create([
                    'name' => $mealData['name'],
                    'name_ar' => $mealData['name_ar'] ?? null,
                    'is_included' => $mealData['is_included'] ?? 0,
                    'notes' => $mealData['notes'] ?? null,
                    'is_active' => $mealData['is_active'] ?? 1,
                ]);

                // Create meal rates for each season
                if (!empty($seasonIds)) {
                    foreach ($seasonIds as $seasonId) {
                        $accommodation->mealRates()->create([
                            'season_id' => $seasonId,
                            'meal_id' => $meal->id,
                            'currency_id' => $mealData['currency_id'],
                            'price' => $mealData['price'],
                            'is_supplement' => $mealData['is_supplement'] ?? 1,
                            'is_active' => $mealData['is_active'] ?? 1,
                        ]);
                    }
                }
            }
        }

        // Process Supplements
        if (!empty($data['supplements']) && is_array($data['supplements'])) {
            foreach ($data['supplements'] as $supplementData) {
                $accommodation->supplements()->create([
                    'name' => $supplementData['name'],
                    'name_ar' => $supplementData['name_ar'] ?? null,
                    'currency_id' => $supplementData['currency_id'],
                    'price' => $supplementData['price'],
                    'price_type' => $supplementData['price_type'] ?? 'per_person',
                    'is_mandatory' => $supplementData['is_mandatory'] ?? 0,
                    'is_active' => $supplementData['is_active'] ?? 1,
                    'notes' => $supplementData['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('accommodations.index')->withSuccess(__('messages.type_updated', ['type' => __('main.accommodation')]));
    }

    public function show($id)
    {
        $accommodation = Accommodation::with(['supplements', 'currency', 'type', 'seasons', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        }
        return view('pages.dashboard.accommodations.show', compact('accommodation'));
    }

    public function edit($id)
    {
        $accommodation = Accommodation::with(['currency', 'type', 'seasons', 'roomRates', 'mealRates', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        }
        $types = Type::orderBy('name')->get();

        $seasons = Season::orderBy('name')->get();
        $seasonsSelected = $accommodation->seasons->map(function ($season) {
            return ['id' => $season->id, 'name' => $season->name];
        })->toArray();

        $rooms = Room::orderBy('name')->get();
        $roomsSelected = $accommodation->roomRates->map(function ($room) {
            return ['id' => $room->id, 'name' => $room->name];
        })->toArray();

        $meals = Meal::orderBy('name')->get();
        $mealsSelected = $accommodation->mealRates->map(function ($meal) {
            return ['id' => $meal->id, 'name' => $meal->name];
        })->toArray();

        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.accommodations.edit', compact('accommodation', 'types', 'seasons', 'seasonsSelected', 'rooms', 'roomsSelected', 'meals', 'mealsSelected', 'currencies', 'regions', 'timezones'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        }

        $data = $request->validated();

        // Update basic fields
        $accommodation->update($request->except(['seasons', 'rooms', 'meals', 'supplements']));

        // Delete old relationships
        $accommodation->roomRates()->delete();
        $accommodation->mealRates()->delete();
        $accommodation->supplements()->delete();

        // Process Seasons
        $seasonIds = [];
        if (!empty($data['seasons']) && is_array($data['seasons'])) {
            foreach ($data['seasons'] as $seasonData) {
                $season = Season::create([
                    'name' => $seasonData['name'],
                    'name_ar' => $seasonData['name_ar'] ?? null,
                    'season_from' => $seasonData['season_from'],
                    'season_to' => $seasonData['season_to'],
                    'is_active' => $seasonData['is_active'] ?? 1,
                    'notes' => $seasonData['notes'] ?? null,
                ]);
                $seasonIds[] = $season->id;
            }
        }

        // Process Rooms
        if (!empty($data['rooms']) && is_array($data['rooms'])) {
            foreach ($data['rooms'] as $roomData) {
                $room = Room::create([
                    'name' => $roomData['name'],
                    'name_ar' => $roomData['name_ar'] ?? null,
                    'max_occupancy' => $roomData['max_occupancy'] ?? null,
                    'occupancy_details' => $roomData['occupancy_details'] ?? null,
                    'notes' => $roomData['notes'] ?? null,
                    'is_active' => $roomData['is_active'] ?? 1,
                ]);

                // Create room rates for each season
                if (!empty($seasonIds)) {
                    foreach ($seasonIds as $seasonId) {
                        $accommodation->roomRates()->create([
                            'season_id' => $seasonId,
                            'room_id' => $room->id,
                            'currency_id' => $roomData['currency_id'],
                            'price_per_person_double' => $roomData['price_per_person_double'],
                            'single_room_supplement' => $roomData['single_room_supplement'] ?? 0,
                            'triple_room_discount' => $roomData['triple_room_discount'] ?? 0,
                            'third_person_price' => $roomData['third_person_price'] ?? 0,
                            'extra_bed_price' => $roomData['extra_bed_price'] ?? 0,
                            'sea_view_supplement' => $roomData['sea_view_supplement'] ?? 0,
                            'is_active' => $roomData['is_active'] ?? 1,
                        ]);
                    }
                }
            }
        }

        // Process Meals
        if (!empty($data['meals']) && is_array($data['meals'])) {
            foreach ($data['meals'] as $mealData) {
                $meal = Meal::create([
                    'name' => $mealData['name'],
                    'name_ar' => $mealData['name_ar'] ?? null,
                    'is_included' => $mealData['is_included'] ?? 0,
                    'notes' => $mealData['notes'] ?? null,
                    'is_active' => $mealData['is_active'] ?? 1,
                ]);

                // Create meal rates for each season
                if (!empty($seasonIds)) {
                    foreach ($seasonIds as $seasonId) {
                        $accommodation->mealRates()->create([
                            'season_id' => $seasonId,
                            'meal_id' => $meal->id,
                            'currency_id' => $mealData['currency_id'],
                            'price' => $mealData['price'],
                            'is_supplement' => $mealData['is_supplement'] ?? 1,
                            'is_active' => $mealData['is_active'] ?? 1,
                        ]);
                    }
                }
            }
        }

        // Process Supplements
        if (!empty($data['supplements']) && is_array($data['supplements'])) {
            foreach ($data['supplements'] as $supplementData) {
                $accommodation->supplements()->create([
                    'name' => $supplementData['name'],
                    'name_ar' => $supplementData['name_ar'] ?? null,
                    'currency_id' => $supplementData['currency_id'],
                    'price' => $supplementData['price'],
                    'price_type' => $supplementData['price_type'] ?? 'per_person',
                    'is_mandatory' => $supplementData['is_mandatory'] ?? 0,
                    'is_active' => $supplementData['is_active'] ?? 1,
                    'notes' => $supplementData['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('accommodations.index')->withSuccess(__('messages.type_updated', ['type' => __('main.accommodation')]));
    }

    public function destroy($id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->withError('الإقامة غير موجودة!');
        }
        $accommodation->delete();
        return redirect()->route('accommodations.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.accommodation')]));
    }
}