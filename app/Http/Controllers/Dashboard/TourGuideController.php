<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Subregion;
use App\Models\TourGuide;
use App\Models\Language;
use App\Models\TourGuideType;
use App\Traits\PhotoUploadTrait;
use App\Models\TourGuideLanguage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuide\TourGuideCreateRequest;
use App\Http\Requests\TourGuide\TourGuideUpdateRequest;

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
        $languages_ids = Language::get(['id', 'name', 'name_ar']);
        $guideTypes = TourGuideType::all();
        $regions = Region::all();
        $subregions = Subregion::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('pages.dashboard.tour-guides.create', get_defined_vars());
    }

    public function store(TourGuideCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated = $request->safe()->except('photo');
            $tourGuide = TourGuide::create($validated);
            $tourGuide->languages()->sync($request->languages_ids);
            $this->uploadPhoto($request, $tourGuide, 'photo', "tour_guides");
            DB::commit();
            $message = __('main.messages.type_created', ['type' => __('main.tour-guide')]);

            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', $message);
            }

            return redirect()->route('tour-guides.index')->with('success', $message);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return redirect()->route('tour-guides.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.tour-guide')]));
        }
    }

    public function store2(TourGuideCreateRequest $request)
    {
        dd($request->all());
        $validated = $request->validated();
        $tourGuide = TourGuide::create($validated);
        $tourGuideLanguage = TourGuideLanguage::insert(array_map(fn($languageId) => ['tour_guide_id' => $tourGuide->id, 'language_id' => $languageId], $request->languages_ids));

        if ($tourGuide && $tourGuideLanguage) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.tour-guide')]));
            }
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
        $currencies = Currency::all();
        $languages_ids = Language::all()->pluck('name', 'id');

        // $tour_guide_languages = TourGuideLanguage::with('language', function ($query) use ($tourGuide) {
        //     $query->where('tour_guide_id', $tourGuide->id);
        // })->get();

        $tour_guide_languages = TourGuideLanguage::with('language')->where('tour_guide_id', $tourGuide->id)->get();
        // dd($tour_guide_languages);

        foreach ($tour_guide_languages as $key => $language) {
            $languages[] = $language->language->id;
        }

        // dd($languages);

        // $tour_guide_languages = TourGuideLanguage::where('tour_guide_id', $tourGuide->id)->pluck('guide_language_id', 'id');
        $guideTypes = TourGuideType::all();

        // dd($tourGuide->toArray(), $tour_guide_languages->toArray(), languages_ids);

        $regions = Region::all();
        $subregions = Subregion::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('pages.dashboard.tour-guides.edit', get_defined_vars());
    }

    public function update(TourGuideUpdateRequest $request, $id)
    {
        $tourGuide = TourGuide::find($id);

        if (!$tourGuide) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }

        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated = $request->safe()->except('photo');

            $tourGuide->update($validated);
            if ($request->has('languages_ids')) {
                $tourGuide->languages()->sync($request->languages_ids);
            }
            $this->uploadPhoto($request, $tourGuide, 'photo', "tour_guides");
            DB::commit();

            return redirect()->route('tour-guides.index')->with('success', __('main.messages.type_updated', ['type' => __('main.tour-guide')]));

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.tour-guide')]));
        }
    }

    public function update2(TourGuideUpdateRequest $request, $id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $validated = $request->validated();
        $updated = $tourGuide->update($validated);
        if ($updated) {
            return redirect()->route('tour-guides.index')->with('success', __('main.messages.type_updated', ['type' => __('main.tour-guide')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.tour-guide')]));
    }

    public function destroy($id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $deleted = $tourGuide->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.tour-guide')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.tour-guide')]));
    }
}