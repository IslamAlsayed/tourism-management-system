<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Meal;
use App\Models\Room;
use App\Models\Season;
use App\Models\Currency;
use Illuminate\Http\Request;
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
        AccommodationRoomRate::create($request->validated());
        return redirect()->route('accommodations-rates.index')->with('success', 'تم إنشاء سعر الغرفة بنجاح!');
    }

    public function editRoomRate($id)
    {
        $roomRate = AccommodationRoomRate::find($id);
        if (!$roomRate) {
            return redirect()->route('accommodations-rates.index')->with('error', 'سعر الغرفة غير موجود!');
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
            return redirect()->route('accommodations-rates.index')->with('error', 'سعر الغرفة غير موجود!');
        }
        $roomRate->update($request->validated());
        return redirect()->route('accommodations-rates.index')->with('success', 'تم تحديث سعر الغرفة بنجاح!');
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
        AccommodationMealRate::create($request->validated());
        return redirect()->route('accommodations-rates.index')->with('success', 'تم إنشاء سعر الوجبة بنجاح!');
    }

    public function editMealRate($id)
    {
        $mealRate = AccommodationMealRate::find($id);
        if (!$mealRate) {
            return redirect()->route('accommodations-rates.index')->with('error', 'سعر الوجبة غير موجود!');
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
            return redirect()->route('accommodations-rates.index')->with('error', 'سعر الوجبة غير موجود!');
        }
        $mealRate->update($request->validated());
        return redirect()->route('accommodations-rates.index')->with('success', 'تم تحديث سعر الوجبة بنجاح!');
    }

    public function importForm()
    {
        return view('pages.dashboard.accommodations-rates.import');
    }

    public function destroyRoomRate($id)
    {
        $rate = AccommodationRoomRate::find($id);
        if (!$rate) {
            return redirect()->route('accommodations-rates.index')->with('error', 'سعر الغرفة غير موجود!');
        }
        $rate->delete();
        return redirect()->route('accommodations-rates.index')->with('success', 'تم حذف سعر الغرفة بنجاح!');
    }

    public function destroyMealRate($id)
    {
        $rate = AccommodationMealRate::find($id);
        if (!$rate) {
            return redirect()->route('accommodations-rates.index')->with('error', 'سعر الوجبة غير موجود!');
        }
        $rate->delete();
        return redirect()->route('accommodations-rates.index')->with('success', 'تم حذف سعر الوجبة بنجاح!');
    }
}