<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Timezone;
use App\Models\Subregion;
use App\Models\Accommodation;
use App\Models\AccommodationType;
use App\Models\Season;
use App\Models\RoomType;
use App\Models\MealType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\StoreAccommodationRequest;
use App\Http\Requests\Accommodations\UpdateAccommodationRequest;

class AccommodationController extends Controller
{
    public function index()
    {
        $accommodations = Accommodation::with(['accommodation_type', 'country', 'city'])->paginate(getPaginate());
        $total = Accommodation::count();
        return view('pages.dashboard.accommodations.index', compact('accommodations', 'total'));
    }

    public function getResultType($type)
    {
        $typeModel = AccommodationType::where('name', 'like', '%' . $type . '%')->first();
        $data = Accommodation::with('type')->where('accommodation_type_id', $typeModel?->id ?? 0)->paginate(getPaginate());
        $total = $data->total();
        return view('pages.dashboard.accommodations.types', compact('data', 'total', 'type'));
    }

    public function createType()
    {
        dd('accommodations create type');
    }

    public function getCreateType($type)
    {
        // Get the accommodation type
        $accommodationType = AccommodationType::where('name', 'like', '%' . $type . '%')->orWhere('name_ar', 'like', '%' . $type . '%')->first();
        if (!$accommodationType) {
            return redirect()->route('accommodations.create')->with('warning', 'نوع الإقامة غير موجود، يرجى اختيار نوع من القائمة.');
        }
        $accommodationTypes = AccommodationType::get();
        $countries = Country::get();
        $cities = City::get();
        $regions = Region::get();
        $subregions = Subregion::get();
        return view('pages.dashboard.accommodations.create-flexible', compact('accommodationTypes', 'countries', 'cities', 'regions', 'subregions', 'accommodationType'));
    }

    public function create()
    {
        $accommodationTypes = AccommodationType::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $roomTypes = RoomType::orderBy('name')->get();
        $mealTypes = MealType::orderBy('name')->get();
        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.accommodations.create-flexible', compact('accommodationTypes', 'seasons', 'roomTypes', 'mealTypes', 'currencies', 'regions', 'timezones'));
    }

    /**
     * Store a new accommodation
     */
    public function store(StoreAccommodationRequest $request)
    {
        $accommodation = Accommodation::create($request->all());
        return redirect()->route('accommodations.index')->with('success', 'تم إنشاء الإقامة بنجاح!');
    }

    /**
     * Show accommodation details
     */
    public function show($id)
    {
        $accommodation = Accommodation::with(['currency', 'accommodation_type', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة.');
        }
        return view('pages.dashboard.accommodations.show', compact('accommodation'));
    }

    /**
     * Edit accommodation
     */
    public function edit($id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }
        $accommodationTypes = AccommodationType::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $roomTypes = RoomType::orderBy('name')->get();
        $mealTypes = MealType::orderBy('name')->get();
        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.accommodations.edit-flexible', compact('accommodation', 'accommodationTypes', 'seasons', 'roomTypes', 'mealTypes', 'currencies', 'regions', 'timezones'));
    }

    /**
     * Update accommodation
     */
    /**
     * Update accommodation
     */
    public function update(UpdateAccommodationRequest $request, $id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }
        $accommodation->update($request->all());
        return redirect()->route('accommodations.index')->with('success', 'تم تحديث الإقامة بنجاح!');
    }

    /**
     * Delete accommodation
     */
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