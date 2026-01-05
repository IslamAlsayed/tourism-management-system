<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Currency;
use App\Models\TourGuideType;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuideType\StoreRequest;
use App\Http\Requests\TourGuideType\UpdateRequest;

class TourGuideTypeController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tour-guides-types.index');
    }

    public function create()
    {
        $currencies = Currency::all();
        $regions = Region::all();
        return view('pages.dashboard.tour-guides-types.create', compact('currencies', 'regions'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        unset($data['state_id'], $data['city_id']);
        $tourGuideType = TourGuideType::create($data);
        if (!$tourGuideType)
            return back()->withError(__('messages.type_creation_failed', ['type' => __('main.tour_guide')]));
        // States
        $stateIds = [];
        if ($request->boolean('all_states') && $request->filled('country_id')) {
            $stateIds = State::where('country_id', $request->country_id)->pluck('id')->toArray();
        } elseif ($request->filled('state_id')) {
            $stateIds = array_unique((array) $request->input('state_id'));
        }
        $tourGuideType->states()->sync($stateIds);
        // Cities
        $cityIds = [];
        if ($request->boolean('all_cities')) {
            if (!empty($stateIds))
                $cityIds = City::whereIn('state_id', $stateIds)->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $tourGuideType->cities()->sync($cityIds);
        return $tourGuideType
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.tour-guide-type')]))
                : redirect()->route('tour-guides-types.index', ['type' => $request->input('type')])->with('success', __('messages.type_created', ['type' => __('main.tour-guide-type')])))
            : redirect()->route('tour-guides-types.index', ['type' => $request->input('type')])->with('error', __('messages.type_creation_failed', ['type' => __('main.tour-guide-type')]));
    }

    public function show($id)
    {
        $tourGuideType = TourGuideType::with(['currency', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$tourGuideType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
        return view('pages.dashboard.tour-guides-types.show', compact('tourGuideType'));
    }

    public function edit($id)
    {
        $tourGuideType = TourGuideType::with((new TourGuideType)->getRelationshipNames())->find($id);
        if (!$tourGuideType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
        $currencies = Currency::all();
        return view('pages.dashboard.tour-guides-types.edit', compact('tourGuideType', 'currencies'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType)
            return redirect()->route('tour-guides-types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tour-guide-type')]));
        $data = $request->validated();
        unset($data['state_id'], $data['city_id']);
        // States
        $stateIds = [];
        if ($request->boolean('all_states') && $request->filled('country_id')) {
            $stateIds = State::where('country_id', $request->country_id)->pluck('id')->toArray();
        } elseif ($request->filled('state_id')) {
            $stateIds = array_unique((array) $request->input('state_id'));
        }
        $tourGuideType->states()->sync($stateIds);
        // Cities
        $cityIds = [];
        if ($request->boolean('all_cities')) {
            if (!empty($stateIds))
                $cityIds = City::whereIn('state_id', $stateIds)->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $tourGuideType->cities()->sync($cityIds);
        $updated = $tourGuideType->update($data);
        return $updated
            ? redirect()->route('tour-guides-types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tour-guide-type')]))
            : redirect()->route('tour-guides-types.index')->withError(__('messages.type_update_failed', ['type' => __('main.tour-guide-type')]));
    }

    public function destroy($id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
        $deleted = $tourGuideType->delete();
        return $deleted
            ? redirect()->route('tour-guides-types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tour-guide-type')]))
            : redirect()->route('tour-guides-types.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tour-guide-type')]));
    }
}