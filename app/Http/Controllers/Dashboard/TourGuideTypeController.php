<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Currency;
use App\Models\TourGuideType;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuideType\TourGuideTypeCreateRequest;
use App\Http\Requests\TourGuideType\TourGuideTypeUpdateRequest;

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
        return view('pages.dashboard.tour-guides-types.create', get_defined_vars());
    }

    public function store(TourGuideTypeCreateRequest $request)
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

            // ✅ احذف المتغيرات اللي مالهاش لزوم من الـ request
            unset($data['_token'], $data['save_and_add']);

            // 🧩 احفظ في قاعدة البيانات
            TourGuideType::create($data);
            DB::commit();
            $message = __('main.messages.type_created', ['type' => __('main.tour-guide-type')]);
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', $message);
            }
            return redirect()->route('tour-guides-types.index')->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('tour-guides-types.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.tour-guide-type')]));
        }
    }

    public function edit($id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
        }
        $currencies = Currency::all();
        $regions = Region::all();
        return view('pages.dashboard.tour-guides-types.edit', get_defined_vars());
    }

    public function update(TourGuideTypeUpdateRequest $request, $id)
    {
        $tourGuideType = TourGuideType::find($id);
        if (!$tourGuideType) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-type')]));
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

            $tourGuideType->update($data);
            if ($request->has('photo')) {
                $this->uploadPhoto($request, $tourGuideType, 'photo', "tour-guides-types");
            }
            DB::commit();
            return redirect()->route('tour-guides-types.index')->with('success', __('main.messages.type_updated', ['type' => __('main.tour-guide-type')]));
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.tour-guide-type')]));
        }
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