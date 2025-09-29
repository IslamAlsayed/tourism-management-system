<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use App\Models\Currency;
use App\Models\TourGuide;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuide\TourGuideCreateRequest;
use App\Http\Requests\TourGuide\TourGuideUpdateRequest;

class TourGuideController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.tour-guides.index');
    }

    public function create()
    {
        $countries = Country::all();
        $currencies = Currency::all();
        return view('pages.dashboard.tour-guides.create', compact('currencies', 'countries'));
    }

    public function store(TourGuideCreateRequest $request)
    {
        $validated = $request->validated();
        $tourGuide = TourGuide::create($validated);
        if ($tourGuide) {
            return redirect()->route('tour-guides.index')->with('success', __('main.messages.type_created', ['type' => __('main.tour-guide')]));
        }
        return redirect()->route('tour-guides.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.tour-guide')]));
    }

    public function edit($id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $countries = Country::all();
        $currencies = Currency::all();
        return view('pages.dashboard.tour-guides.edit', compact('tourGuide', 'countries', 'currencies'));
    }

    public function update(TourGuideUpdateRequest $request, $id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $validated = $request->validated();
        $tourGuide->update($validated);
        return redirect()->route('tour-guides.index')->with('success', __('main.messages.type_updated', ['type' => __('main.tour-guide')]));
    }

    public function destroy($id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $deleted = $tourGuide->delete();
        if ($deleted) {
            return redirect()->route('tour-guides.index')->with('success', __('main.messages.type_deleted', ['type' => __('main.tour-guide')]));
        }
        return redirect()->route('tour-guides.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.tour-guide')]));
    }
}