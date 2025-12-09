<?php

namespace App\Http\Controllers\Dashboard\Accommodations;

use App\Models\City;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Subregion;
use App\Models\Accommodation;
use App\Models\AccommodationType;
use App\Models\Season;
use App\Models\RoomType;
use App\Models\MealType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\Accommodation\StoreRequest;
use App\Http\Requests\Accommodations\Accommodation\UpdateRequest;

class AccommodationController extends Controller
{
    /**
     * Display a listing of accommodations
     */
    public function index()
    {
        return view('pages.dashboard.accommodations.index');
    }

    /**
     * Show the form for creating a new accommodation
     */
    public function create()
    {
        $accommodationTypes = AccommodationType::orderBy('name')->get();
        $seasons = Season::orderBy('name')->get();
        $roomTypes = RoomType::orderBy('name')->get();
        $mealTypes = MealType::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $subregions = Subregion::orderBy('name')->get();
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.accommodations.create', get_defined_vars());
    }

    /**
     * Store a newly created accommodation
     */
    public function store(StoreRequest $request)
    {
        $accommodation = Accommodation::create($request->validated());

        return redirect()
            ->route('accommodations.index')
            ->with('success', 'تم إنشاء الإقامة بنجاح!');
    }

    /**
     * Display the specified accommodation
     */
    public function show($id)
    {
        $accommodation = Accommodation::with(['accommodation_type', 'country', 'city', 'region', 'subregion', 'currency', 'seasons', 'roomRates', 'mealRates'])->find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }
        return view('pages.dashboard.accommodations.show', compact('accommodation'));
    }

    /**
     * Show the form for editing accommodation
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
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $subregions = Subregion::orderBy('name')->get();
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.accommodations.edit', get_defined_vars());
    }

    /**
     * Update the specified accommodation
     */
    public function update(UpdateRequest $request, $id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }
        $accommodation->update($request->validated());

        return redirect()
            ->route('accommodations.index')
            ->with('success', 'تم تحديث الإقامة بنجاح!');
    }

    /**
     * Remove the specified accommodation
     */
    public function destroy($id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            return redirect()->route('accommodations.index')->with('error', 'الإقامة غير موجودة!');
        }
        $accommodation->delete();

        return redirect()
            ->route('accommodations.index')
            ->with('success', 'تم حذف الإقامة بنجاح!');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('pages.dashboard.accommodations.import');
    }
}