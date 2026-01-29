<?php

namespace App\Http\Controllers\Dashboard\Tours;

use App\Models\Language;
use App\Models\TourGuide;
use App\Models\TourGuideType;
use App\Traits\PhotoUploadTrait;
use App\Models\TourGuideLanguage;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuide\StoreRequest;
use App\Http\Requests\TourGuide\UpdateRequest;

class GuideController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tours.guides.index');
    }

    public function create()
    {
        $languages = Language::get(['id', 'name', 'name_ar']);
        $guideTypes = TourGuideType::get(['id', 'type']);
        $language_ids = TourGuideLanguage::with('language')->pluck('language_id', 'id')->toArray();
        return view('pages.dashboard.tours.guides.create', get_defined_vars());
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
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $tourGuide, 'photo', "tour-guides");
        }
        return $tourGuide
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.tours.guide')]))
                : redirect()->route('tours.guides.index')->with('success', __('messages.type_created', ['type' => __('main.tours.guide')])))
            : redirect()->route('tours.guides.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.tours.guide')]));
    }

    public function show($id)
    {
        $tourGuide = TourGuide::with((new TourGuide())->getRelationshipNames())->find($id);
        if (!$tourGuide)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide')]));
        return view('pages.dashboard.tours.guides.show', compact('tourGuide'));
    }

    public function edit($id)
    {
        $tourGuide = TourGuide::with((new TourGuide())->getRelationshipNames())->find($id);
        if (!$tourGuide)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide')]));
        $tourGuide->language_ids = TourGuideLanguage::with('language')->where('tour_guide_id', $tourGuide->id)->pluck('language_id', 'id')->toArray();
        $languages = Language::get(['id', 'name', 'name_ar']);
        $guideTypes = TourGuideType::get(['id', 'type']);
        return view('pages.dashboard.tours.guides.edit', get_defined_vars());
    }

    public function update(UpdateRequest $request, $id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide')]));
        $data = $request->validated();
        $data = array_merge($data, $request->safe()->except(['photo']));
        $data['updated_by'] = getActiveUserId();
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
        return $updated
            ? redirect()->route('tours.guides.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tours.guide')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tours.guide')]));
    }

    public function destroy($id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide')]));
        $deleted = $tourGuide->delete();
        return $deleted
            ? redirect()->route('tours.guides.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tours.guide')]))
            : redirect()->route('tours.guides.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tours.guide')]));
    }
}
