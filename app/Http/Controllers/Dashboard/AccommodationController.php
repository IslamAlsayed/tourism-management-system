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
        $accommodations = Accommodation::with(['type', 'country', 'city'])->paginate(getPaginate());
        $total = Accommodation::count();
        return view('pages.dashboard.accommodations.index', compact('accommodations', 'total'));
    }

    public function getResultType($type)
    {
        $typeModel = Type::where('name', 'like', '%' . $type . '%')->first();
        $data = Accommodation::with('type')->where('type_id', $typeModel?->id ?? 0)->paginate(getPaginate());
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
        $type = Type::where('name', 'like', '%' . $type . '%')->orWhere('name_ar', 'like', '%' . $type . '%')->first();
        if (!$type) {
            return redirect()->route('accommodations.create')->with('warning', 'نوع الإقامة غير موجود، يرجى اختيار نوع من القائمة.');
        }
        $types = Type::get();
        $countries = Country::get();
        $cities = City::get();
        $regions = Region::get();
        $subregions = Subregion::get();
        return view('pages.dashboard.accommodations.create-flexible', compact('types', 'countries', 'cities', 'regions', 'subregions', 'type'));
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
        $accommodation = Accommodation::with(['currency', 'type', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
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
        $types = Type::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        $meals = Meal::orderBy('name')->get();
        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.accommodations.edit-flexible', compact('accommodation', 'types', 'seasons', 'rooms', 'meals', 'currencies', 'regions', 'timezones'));
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