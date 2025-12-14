<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Currency;
use App\Models\Language;
use App\Models\TourGuide;
use App\Models\TourGuideType;
use App\Traits\PhotoUploadTrait;
use App\Models\TourGuideLanguage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuide\StoreRequest;
use App\Http\Requests\TourGuide\UpdateRequest;
use Illuminate\Support\Facades\Log;

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
        return view('pages.dashboard.tour-guides.create', compact('currencies', 'languages_ids', 'guideTypes', 'regions'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if ($request['state_id']) {
                $data['state_id'] = array_unique($data['state_id']);
            }
            if ($request['city_id']) {
                $data['city_id'] = array_unique($data['city_id']);
            }

            // ✅ اجلب قيم IDs الحالية (لو المستخدم اختار يدويًا)
            $stateIds = $data['state_id'] ?? [];
            $cityIds = $data['city_id'] ?? [];

            // ✅ في حالة all_states = 1 → اجلب كل states حسب الدولة المختارة
            if (!empty($data['all_states']) && $data['all_states'] == 1) {
                $stateIds = State::where('country_id', $data['country_id'])->pluck('id')->toArray();
            }

            // ✅ في حالة all_cities = 1 → اجلب كل المدن بناءً على الدولة أو الـ states
            if (!empty($data['all_cities']) && $data['all_cities'] == 1) {
                // لو اختار "كل المدن" لكن كمان فعّل "كل المحافظات" → نجيب حسب الدولة فقط
                if (!empty($data['all_states']) && $data['all_states'] == 1) {
                    $cityIds = City::where('country_id', $data['country_id'])->pluck('id')->toArray();
                } else {
                    // لو اختار بعض المحافظات فقط
                    $cityIds = City::whereIn('state_id', $stateIds)->pluck('id')->toArray();
                }
            }

            // ✅ خزنها كـ string (comma-separated)
            $data['state_id'] = !empty($stateIds) ? implode(',', $stateIds) : null;
            $data['city_id'] = !empty($cityIds) ? implode(',', $cityIds) : null;

            $data = array_merge($data, $request->safe()->except('photo'));
            $tourGuide = TourGuide::create($data);
            $tourGuide->languages()->sync($request->languages_ids);
            $this->uploadPhoto($request, $tourGuide, 'photo', "tour-guides");
            DB::commit();
            $message = __('messages.type_created', ['type' => __('main.tour-guide')]);
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess($message);
            }
            return redirect()->route('tour-guides.index')->withSuccess($message);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('tour-guides.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tour-guide')]));
        }
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
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $currencies = Currency::all();
        $languages_ids = Language::get(['id', 'name', 'name_ar']);
        $guideTypes = TourGuideType::all();
        $regions = Region::all();
        $tour_guide_languages = TourGuideLanguage::with('language', function ($query) use ($tourGuide) {
            $query->where('tour_guide_id', $tourGuide->id);
        })->get();

        $tour_guide_languages = TourGuideLanguage::with('language')->where('tour_guide_id', $tourGuide->id)->get();
        // dd($tour_guide_languages);

        foreach ($tour_guide_languages as $key => $language) {
            $languages[] = $language->language->id;
        }

        // dd($languages);

        // $tour_guide_languages = TourGuideLanguage::where('tour_guide_id', $tourGuide->id)->pluck('guide_language_id', 'id');
        $guideTypes = TourGuideType::all();

        // dd($tourGuide->toArray(), $tour_guide_languages->toArray(), languages_ids);

        return view('pages.dashboard.tour-guides.edit', compact('currencies', 'languages_ids', 'guideTypes', 'regions', 'tourGuide', 'tour_guide_languages'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($request['state_id']) {
                $data['state_id'] = array_unique($data['state_id']);
            }
            if ($request['city_id']) {
                $data['city_id'] = array_unique($data['city_id']);
            }
            $data = array_merge($data, $request->safe()->except('photo'));
            $tourGuide->update($data);
            if ($request->has('languages_ids')) {
                $tourGuide->languages()->sync($request->languages_ids);
            }
            if ($request->has('photo')) {
                $this->uploadPhoto($request, $tourGuide, 'photo', "tour-guides");
            }
            DB::commit();
            return redirect()->route('tour-guides.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tour-guide')]));
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            Log::error('TourGuide Update Error: ' . $e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tour-guide')]));
        }
    }

    public function destroy($id)
    {
        $tourGuide = TourGuide::find($id);
        if (!$tourGuide) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide')]));
        }
        $deleted = $tourGuide->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.tour-guide')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.tour-guide')]));
    }
}