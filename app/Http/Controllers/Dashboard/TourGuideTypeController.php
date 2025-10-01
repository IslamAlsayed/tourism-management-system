<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Subregion;
use App\Models\TourGuideType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuideType\TourGuideTypeCreateRequest;
use App\Http\Requests\TourGuideType\TourGuideTypeUpdateRequest;

class TourGuideTypeController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.tour-guides-types.index');
    }

    public function create()
    {
        $currencies = Currency::all();
        $countries = Country::all();
        $states = State::limit(25)->get(['id', 'name', 'name_ar']);
        $cities = City::limit(25)->get(['id', 'name', 'name_ar']);
        $regions = Region::all();
        $subregions = Subregion::all();

        return view('pages.dashboard.tour-guides-types.create', compact('currencies', 'countries', 'states', 'cities', 'regions', 'subregions'));
    }

    public function store(TourGuideTypeCreateRequest $request)
    {
        $validated = $request->validated();
        $tourGuideType = TourGuideType::create($validated);
        if ($tourGuideType) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.tour-guides-type')]));
            }
            return redirect()->route('tour-guides-types.index')->with('success', __('main.messages.type_created', ['type' => __('main.tour-guides-type')]));
        }
        return redirect()->route('tour-guides-types.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.tour-guides-type')]));
    }

    public function edit($id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
        }
        $currencies = Currency::all();
        $countries = Country::all();
        $states = State::limit(25)->get(['id', 'name', 'name_ar']);
        $cities = City::limit(25)->get(['id', 'name', 'name_ar']);
        $regions = Region::all();
        $subregions = Subregion::all();

        return view('pages.dashboard.tour-guides-types.edit', compact('tourGuideType', 'countries', 'currencies', 'regions', 'subregions', 'states', 'cities'));
    }

    public function update(TourGuideTypeUpdateRequest $request, $id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
        }
        $validated = $request->validated();
        $updated = $tourGuideType->update($validated);
        if ($updated) {
            return redirect()->route('tour-guides-types.index')->with('success', __('main.messages.type_updated', ['type' => __('main.tour-guides-type')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.tour-guides-type')]));
    }

    public function destroy($id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
        }
        $deleted = $tourGuideType->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.tour-guides-type')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.tour-guides-type')]));
    }
}