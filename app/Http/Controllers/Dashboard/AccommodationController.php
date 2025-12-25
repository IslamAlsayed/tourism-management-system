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

        // Attach seasons with price in pivot table
        if (!empty($data['seasons']) && is_array($data['seasons'])) {
            $seasonsToSync = [];
            foreach ($data['seasons'] as $season) {
                if (isset($season['season_id']) && isset($season['price'])) {
                    $seasonsToSync[$season['season_id']] = ['price' => $season['price']];
                }
            }
            if (!empty($seasonsToSync)) {
                $accommodation->seasons()->sync($seasonsToSync);
            }
        }

        // Attach rooms with price in pivot table
        if (!empty($data['rooms']) && is_array($data['rooms'])) {
            $roomsToSync = [];
            foreach ($data['rooms'] as $room) {
                if (isset($room['room_id']) && isset($room['price'])) {
                    $roomsToSync[$room['room_id']] = ['price' => $room['price']];
                }
            }
            if (!empty($roomsToSync)) {
                $accommodation->rooms()->sync($roomsToSync);
            }
        }

        // Attach meals with price in pivot table
        if (!empty($data['meals']) && is_array($data['meals'])) {
            $mealsToSync = [];
            foreach ($data['meals'] as $meal) {
                if (isset($meal['meal_id']) && isset($meal['price'])) {
                    $mealsToSync[$meal['meal_id']] = ['price' => $meal['price']];
                }
            }
            if (!empty($mealsToSync)) {
                $accommodation->meals()->sync($mealsToSync);
            }
        }

        // Attach supplements with price in pivot table
        if (!empty($data['supplements']) && is_array($data['supplements'])) {
            $supplementsToSync = [];
            foreach ($data['supplements'] as $supplement) {
                if (isset($supplement['supplement_id']) && isset($supplement['price'])) {
                    $supplementsToSync[$supplement['supplement_id']] = ['price' => $supplement['price']];
                }
            }
            if (!empty($supplementsToSync)) {
                $accommodation->supplements()->sync($supplementsToSync);
            }
        }

        return redirect()->route('accommodations.index')->withSuccess(__('messages.type_updated', ['type' => __('main.accommodation')]));
    }

    public function show($id)
    {
        $accommodation = Accommodation::with(['supplements', 'currency', 'type', 'seasons', 'rooms', 'meals', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        }
        return view('pages.dashboard.accommodations.show', compact('accommodation'));
    }

    public function edit($id)
    {
        $accommodation = Accommodation::with(['currency', 'type', 'seasons', 'rooms', 'meals', 'supplements', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        }
        $types = Type::orderBy('name')->get();

        // Get all available seasons/meals/supplements for selection
        $availableSeasons = Season::orderBy('name')->get();
        $selectedSeasons = $accommodation->seasons->map(function ($season) {
            return [
                'id' => $season->id,
                'name' => $season->name,
                'price' => $season->pivot->price ?? 0
            ];
        })->toArray();

        $availableRooms = Room::orderBy('name')->get();
        $selectedRooms = $accommodation->rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'price' => $room->pivot->price ?? 0
            ];
        })->toArray();

        $availableMeals = Meal::orderBy('name')->get();
        $selectedMeals = $accommodation->meals->map(function ($meal) {
            return [
                'id' => $meal->id,
                'name' => $meal->name,
                'price' => $meal->pivot->price ?? 0
            ];
        })->toArray();

        $availableSupplements = \App\Models\Supplement::orderBy('name')->get();
        $selectedSupplements = $accommodation->supplements->map(function ($supplement) {
            return [
                'id' => $supplement->id,
                'name' => $supplement->name,
                'price' => $supplement->pivot->price ?? 0
            ];
        })->toArray();

        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.accommodations.edit', compact('accommodation', 'types', 'availableSeasons', 'selectedSeasons', 'availableRooms', 'selectedRooms', 'availableMeals', 'selectedMeals', 'availableSupplements', 'selectedSupplements', 'currencies', 'regions', 'timezones'));
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

        // Sync seasons with price in pivot table
        if (isset($data['seasons']) && is_array($data['seasons'])) {
            $seasonsToSync = [];
            foreach ($data['seasons'] as $season) {
                if (isset($season['season_id']) && isset($season['price'])) {
                    $seasonsToSync[$season['season_id']] = ['price' => $season['price']];
                }
            }
            $accommodation->seasons()->sync($seasonsToSync);
        } else {
            $accommodation->seasons()->sync([]);
        }

        // Sync rooms with price in pivot table
        if (isset($data['rooms']) && is_array($data['rooms'])) {
            $roomsToSync = [];
            foreach ($data['rooms'] as $room) {
                if (isset($room['room_id']) && isset($room['price'])) {
                    $roomsToSync[$room['room_id']] = ['price' => $room['price']];
                }
            }
            $accommodation->rooms()->sync($roomsToSync);
        } else {
            $accommodation->rooms()->sync([]);
        }

        // Sync meals with price in pivot table
        if (isset($data['meals']) && is_array($data['meals'])) {
            $mealsToSync = [];
            foreach ($data['meals'] as $meal) {
                if (isset($meal['meal_id']) && isset($meal['price'])) {
                    $mealsToSync[$meal['meal_id']] = ['price' => $meal['price']];
                }
            }
            $accommodation->meals()->sync($mealsToSync);
        } else {
            $accommodation->meals()->sync([]);
        }

        // Sync supplements with price in pivot table
        if (isset($data['supplements']) && is_array($data['supplements'])) {
            $supplementsToSync = [];
            foreach ($data['supplements'] as $supplement) {
                if (isset($supplement['supplement_id']) && isset($supplement['price'])) {
                    $supplementsToSync[$supplement['supplement_id']] = ['price' => $supplement['price']];
                }
            }
            $accommodation->supplements()->sync($supplementsToSync);
        } else {
            $accommodation->supplements()->sync([]);
        }

        return redirect()->route('accommodations.index')->withSuccess(__('messages.type_updated', ['type' => __('main.accommodation')]));
    }

    public function destroy($id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.accommodation')]));
        }
        $deleted = $accommodation->delete();
        if ($deleted) {
            return redirect()->route('accommodations.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.accommodation')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.accommodation')]));
    }
}