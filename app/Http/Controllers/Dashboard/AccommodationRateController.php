<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Meal;
use App\Models\Room;
use App\Models\Season;
use App\Models\Currency;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Models\AccommodationMealRate;
use App\Models\AccommodationRoomRate;
use App\Http\Requests\AccommodationRate\StoreMealRequest;
use App\Http\Requests\AccommodationRate\StoreRoomRequest;
use App\Http\Requests\AccommodationRate\UpdateMealRequest;
use App\Http\Requests\AccommodationRate\UpdateRoomRequest;

class AccommodationRateController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.accommodations-rates.index');
    }

    public function createRoomRate()
    {
        $accommodations = Accommodation::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        return view('pages.dashboard.accommodations-rates.create-room', compact('accommodations', 'seasons', 'currencies', 'rooms'));
    }

    public function storeRoomRate(StoreRoomRequest $request)
    {
        $validated = $request->all();
        $accommodation_room_rate = AccommodationRoomRate::create($validated);
        if ($accommodation_room_rate) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.room_rate')]));
            }
            return redirect()->route('accommodations-rates.index')->withSuccess(__('messages.type_created', ['type' => __('main.room_rate')]));
        }
        return redirect()->route('accommodations-rates.index')->withError(__('messages.type_creation_failed', ['type' => __('main.room_rate')]));
    }

    public function editRoomRate($id)
    {
        $roomRate = AccommodationRoomRate::find($id);
        if (!$roomRate) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room_rate')]));
        }
        $accommodations = Accommodation::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        return view('pages.dashboard.accommodations-rates.edit-room', compact('roomRate', 'accommodations', 'seasons', 'currencies', 'rooms'));
    }

    public function updateRoomRate(UpdateRoomRequest $request, $id)
    {
        $roomRate = AccommodationRoomRate::find($id);
        if (!$roomRate) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room_rate')]));
        }
        $updated = $roomRate->update($request->all());
        if ($updated) {
            return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.room_rate')]));
        }
        return redirect()->route('accommodations-rates.index')->withSuccess(__('messages.type_updated', ['type' => __('main.room_rate')]));
    }

    public function createMealRate()
    {
        $accommodations = Accommodation::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $meals = Meal::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        return view('pages.dashboard.accommodations-rates.create-meal', compact('accommodations', 'seasons', 'currencies', 'meals'));
    }

    public function storeMealRate(StoreMealRequest $request)
    {
        $validated = $request->all();
        $accommodation_meal_rate = AccommodationMealRate::create($validated);
        if ($accommodation_meal_rate) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.meal_rate')]));
            }
            return redirect()->route('accommodations-rates.index')->withSuccess(__('messages.type_created', ['type' => __('main.meal_rate')]));
        }
        return redirect()->route('accommodations-rates.index')->withError(__('messages.type_creation_failed', ['type' => __('main.meal_rate')]));
    }

    public function editMealRate($id)
    {
        $mealRate = AccommodationMealRate::find($id);
        if (!$mealRate) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal_rate')]));
        }
        $accommodations = Accommodation::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $meals = Meal::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        return view('pages.dashboard.accommodations-rates.edit-meal', compact('mealRate', 'accommodations', 'seasons', 'currencies', 'meals'));
    }

    public function updateMealRate(UpdateMealRequest $request, $id)
    {
        $mealRate = AccommodationMealRate::find($id);
        if (!$mealRate) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal_rate')]));
        }
        $updated = $mealRate->update($request->all());
        if ($updated) {
            return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.meal_rate')]));
        }
        return redirect()->route('accommodations-rates.index')->withSuccess(__('messages.type_updated', ['type' => __('main.meal_rate')]));
    }

    public function destroyRoomRate($id)
    {
        $rate = AccommodationRoomRate::find($id);
        if (!$rate) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room_rate')]));
        }
        $deleted = $rate->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.room_rate')]));
        }
        return redirect()->route('accommodations-rates.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.room_rate')]));
    }

    public function destroyMealRate($id)
    {
        $rate = AccommodationMealRate::find($id);
        if (!$rate) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal_rate')]));
        }
        $deleted = $rate->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.meal_rate')]));
        }
        return redirect()->route('accommodations-rates.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.meal_rate')]));
    }
}