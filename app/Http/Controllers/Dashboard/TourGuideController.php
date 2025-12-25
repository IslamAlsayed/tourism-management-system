<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\Currency;
use App\Models\Language;
use App\Models\TourGuide;
use App\Models\TourGuideType;
use App\Traits\PhotoUploadTrait;
use App\Models\TourGuideLanguage;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuide\StoreRequest;
use App\Http\Requests\TourGuide\UpdateRequest;

class TourGuideController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tour-guides.index');
    }

    public function create()
    {
        $currencies = Currency::all();
        $languages = Language::get(['id', 'name', 'name_ar']);
        $guideTypes = TourGuideType::all();
        $regions = Region::all();
        $language_ids = TourGuideLanguage::with('language')->pluck('language_id', 'id')->toArray();
        return view('pages.dashboard.tour-guides.create', get_defined_vars());
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data = array_merge($data, $request->safe()->except(['photo']));
        $tourGuide = TourGuide::create($data);
        if ($tourGuide && $request['language_id']) {
            foreach ($request['language_id'] as $language_id) {
                TourGuideLanguage::create([
                    'tour_guide_id' => $tourGuide->id,
                    'language_id' => $language_id,
                ]);
            }
        }
        $this->uploadPhoto($request, $tourGuide, 'photo', "tour-guides");
        if ($tourGuide) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tour-guide')]));
            }
            return redirect()->route('tour-guides.index')->withSuccess(__('messages.type_created', ['type' => __('main.tour-guide')]));
        }
        return redirect()->route('tour-guides.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tour-guide')]));
    }

    public function show($id)
    {
        $tourGuide = TourGuide::with(['currency', 'guide_type', 'tourGuideLanguages', 'region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$tourGuide) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        return view('pages.dashboard.tour-guides.show', compact('tourGuide'));
    }

    public function edit($id)
    {
        $tourGuide = TourGuide::with('tourGuideLanguages')->find($id);
        if (!$tourGuide) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $tour_guide_languages = TourGuideLanguage::with('language')->where('tour_guide_id', $tourGuide->id)->pluck('language_id', 'id')->toArray();
        $tourGuide->language_ids = $tour_guide_languages;
        $currencies = Currency::all();
        $languages = Language::get(['id', 'name', 'name_ar']);
        $guideTypes = TourGuideType::all();
        $regions = Region::all();
        return view('pages.dashboard.tour-guides.edit', get_defined_vars());
    }

    public function update(UpdateRequest $request, $id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $data = $request->validated();
        $data = array_merge($data, $request->safe()->except(['photo']));
        $data['updated_by'] = getActiveUser()->id;
        $updated = $tourGuide->update($data);

        if ($tourGuide && $request['language_id']) {
            $tourGuide->tourGuideLanguages()->delete();
            foreach ($request['language_id'] as $language_id) {
                TourGuideLanguage::create([
                    'tour_guide_id' => $tourGuide->id,
                    'language_id' => $language_id,
                ]);
            }
        }
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $tourGuide, 'photo', "tour-guides");
        }
        if ($updated) {
            return redirect()->route('tour-guides.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tour-guide')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tour-guide')]));
    }

    public function destroy($id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $deleted = $tourGuide->delete();
        if ($deleted) {
            return redirect()->route('tour-guides.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tour-guide')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.tour-guide')]));
    }
}