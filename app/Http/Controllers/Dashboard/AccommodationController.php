<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Timezone;
use App\Models\Subregion;
use App\Models\Accommodation;
use App\Models\Type;
use App\Models\Season;
use App\Models\Room;
use App\Models\Meal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\StoreAccommodationRequest;
use App\Http\Requests\Accommodations\UpdateAccommodationRequest;

class AccommodationController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.accommodations.index');
    }

    // public function getResultType($type)
    // {
    //     $typeModel = Type::where('name', 'like', '%' . $type . '%')->first();
    //     $data = Accommodation::with('type')->where('type_id', $typeModel?->id ?? 0)->paginate(getPaginate());
    //     $total = $data->total();
    //     return view('pages.dashboard.accommodations.types', compact('data', 'total', 'type'));
    // }

    // public function createType()
    // {
    //     dd('accommodations create type');
    // }

    // public function getCreateType($type)
    // {
    //     // Get the accommodation type
    //     $type = Type::where('name', 'like', '%' . $type . '%')->orWhere('name_ar', 'like', '%' . $type . '%')->first();
    //     if (!$type) {
    //         return redirect()->route('accommodations.create')->with('warning', 'نوع الإقامة غير موجود، يرجى اختيار نوع من القائمة.');
    //     }
    //     $types = Type::get();
    //     $countries = Country::get();
    //     $cities = City::get();
    //     $regions = Region::get();
    //     $subregions = Subregion::get();
    //     return view('pages.dashboard.accommodations.create', compact('types', 'countries', 'cities', 'regions', 'subregions', 'type'));
    // }

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

    public function store(StoreAccommodationRequest $request)
    {
        $data = $request->validated();

        // Create accommodation (basic fields only)
        $accommodation = Accommodation::create($request->except(['season_ids', 'room_ids', 'meal_ids']));

        // Attach seasons (Many-to-Many via accommodation_seasons)
        if (!empty($data['season_ids']) && is_array($data['season_ids'])) {
            $accommodation->seasons()->attach($data['season_ids']);
        }

        // Create room rates: لكل season + room، ننشئ rate record بأسعار افتراضية (0)
        if (!empty($data['room_ids']) && !empty($data['season_ids'])) {
            foreach ($data['season_ids'] as $seasonId) {
                foreach ($data['room_ids'] as $roomId) {
                    $accommodation->roomRates()->create([
                        'season_id' => $seasonId,
                        'room_id' => $roomId,
                        'currency_id' => $request->currency_id ?? 1,
                        'price_per_person_double' => 0,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Create meal rates: لكل season + meal، ننشئ rate record بسعر افتراضي (0)
        if (!empty($data['meal_ids']) && !empty($data['season_ids'])) {
            foreach ($data['season_ids'] as $seasonId) {
                foreach ($data['meal_ids'] as $mealId) {
                    $accommodation->mealRates()->create([
                        'season_id' => $seasonId,
                        'meal_id' => $mealId,
                        'currency_id' => $request->currency_id ?? 1,
                        'price' => 0,
                        'is_supplement' => true,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('accommodations.index')->with('success', 'تم إنشاء الإقامة بنجاح!');
    }

    public function show($id)
    {
        $accommodation = Accommodation::with(['currency', 'types', 'seasons', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة.');
        }
        return view('pages.dashboard.accommodations.show', compact('accommodation'));
    }

    public function edit($id)
    {
        $accommodation = Accommodation::with(['currency', 'type', 'seasons', 'roomRates.room', 'mealRates.meal', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }
        $types = Type::orderBy('name')->get();

        $seasons = Season::orderBy('name')->get();
        $seasonsSelected = $accommodation->seasons->map(function ($season) {
            return ['id' => $season->id, 'name' => $season->name];
        })->toArray();

        $rooms = Room::orderBy('name')->get();
        $roomsSelected = $accommodation->roomRates->map(function ($roomRate) {
            return ['id' => $roomRate->room->id, 'name' => $roomRate->room->name];
        })->toArray();

        $meals = Meal::orderBy('name')->get();
        $mealsSelected = $accommodation->mealRates->map(function ($mealRate) {
            return ['id' => $mealRate->meal->id, 'name' => $mealRate->meal->name];
        })->toArray();

        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.accommodations.edit', compact('accommodation', 'types', 'seasons', 'seasonsSelected', 'rooms', 'roomsSelected', 'meals', 'mealsSelected', 'currencies', 'regions', 'timezones'));
    }

    public function update(UpdateAccommodationRequest $request, $id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }

        $data = $request->validated();

        // Update basic fields
        $accommodation->update($request->except(['season_ids', 'room_ids', 'meal_ids']));

        // Sync seasons (Many-to-Many via accommodation_seasons)
        if (isset($data['season_ids']) && is_array($data['season_ids'])) {
            $accommodation->seasons()->sync($data['season_ids']);
        }

        // Get current seasons after sync
        $currentSeasonIds = $accommodation->seasons()->pluck('seasons.id')->toArray();

        // Sync room rates: حذف القديمة وإنشاء الجديدة
        if (isset($data['room_ids']) && !empty($currentSeasonIds)) {
            // Delete old room rates
            $accommodation->roomRates()->delete();

            // Create new room rates for each season × room combination
            foreach ($currentSeasonIds as $seasonId) {
                foreach ($data['room_ids'] as $roomId) {
                    $accommodation->roomRates()->create([
                        'season_id' => $seasonId,
                        'room_id' => $roomId,
                        'currency_id' => $request->currency_id ?? 1,
                        'price_per_person_double' => 0,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Sync meal rates: حذف القديمة وإنشاء الجديدة
        if (isset($data['meal_ids']) && !empty($currentSeasonIds)) {
            // Delete old meal rates
            $accommodation->mealRates()->delete();

            // Create new meal rates for each season × meal combination
            foreach ($currentSeasonIds as $seasonId) {
                foreach ($data['meal_ids'] as $mealId) {
                    $accommodation->mealRates()->create([
                        'season_id' => $seasonId,
                        'meal_id' => $mealId,
                        'currency_id' => $request->currency_id ?? 1,
                        'price' => 0,
                        'is_supplement' => true,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('accommodations.index')->with('success', 'تم تحديث الإقامة بنجاح!');
    }

    public function destroy($id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }
        $accommodation->delete();
        return redirect()->route('accommodations.index')->with('success', 'تم حذف الإقامة بنجاح!');
    }
}