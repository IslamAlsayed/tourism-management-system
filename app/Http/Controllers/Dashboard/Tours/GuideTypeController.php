<?php

namespace App\Http\Controllers\Dashboard\Tours;

use App\Models\City;
use App\Models\State;
use App\Models\TourGuideType;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuideType\StoreRequest;
use App\Http\Requests\TourGuideType\UpdateRequest;

class GuideTypeController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tours.guides-types.index');
    }

    public function create()
    {
        return view('pages.dashboard.tours.guides-types.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        unset($validated['state_id'], $validated['city_id']);
        $tourGuideType = TourGuideType::create($validated);
        if (!$tourGuideType)
            return back()->withError(__('messages.type_creation_failed', ['type' => __('main.tours.guide')]));
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
        if ($request->boolean('all_cities') && $request->filled('country_id')) {
            if (!empty($stateIds))
                $cityIds = City::whereIn('state_id', $stateIds)->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $tourGuideType->cities()->sync($cityIds);
        return $tourGuideType
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.tours.guide-type')]))
                : redirect()->route('tours.guides-types.index', ['type' => $request->input('type')])->with('success', __('messages.type_created', ['type' => __('main.tours.guide-type')])))
            : redirect()->route('tours.guides-types.index', ['type' => $request->input('type')])->with('error', __('messages.type_creation_failed', ['type' => __('main.tours.guide-type')]));
    }

    public function show($id)
    {
        $tourGuideType = TourGuideType::with((new TourGuideType)->getRelationshipNames())->find($id);
        if (!$tourGuideType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide-type')]));
        return view('pages.dashboard.tours.guides-types.show', compact('tourGuideType'));
    }

    public function edit($id)
    {
        $tourGuideType = TourGuideType::with((new TourGuideType)->getRelationshipNames())->find($id);
        if (!$tourGuideType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide-type')]));
        return view('pages.dashboard.tours.guides-types.edit', compact('tourGuideType'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType)
            return redirect()->route('tours.guides-types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tours.guide-type')]));
        $validated = $request->validated();
        unset($validated['state_id'], $validated['city_id']);
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
        if ($request->boolean('all_cities') && $request->filled('country_id')) {
            if (!empty($stateIds))
                $cityIds = City::whereIn('state_id', $stateIds)->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $tourGuideType->cities()->sync($cityIds);
        $updated = $tourGuideType->update($validated);
        return $updated
            ? redirect()->route('tours.guides-types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tours.guide-type')]))
            : redirect()->route('tours.guides-types.index')->withError(__('messages.type_update_failed', ['type' => __('main.tours.guide-type')]));
    }

    public function destroy($id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide-type')]));
        $deleted = $tourGuideType->delete();
        return $deleted
            ? redirect()->route('tours.guides-types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tours.guide-type')]))
            : redirect()->route('tours.guides-types.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tours.guide-type')]));
    }
}