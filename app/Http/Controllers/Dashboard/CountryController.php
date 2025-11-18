<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryCreateRequest;
use App\Http\Requests\Country\CountryUpdateRequest;

class CountryController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.countries.index');
    }

    public function create()
    {
        $currencies = Currency::orderBy('code')->get();
        $languages = Language::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.countries.create', get_defined_vars());
    }

    public function store(CountryCreateRequest $request)
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

            $zone = $request->input('timezone');
            $zone = trim(preg_replace('/\s*\(.*\)$/', '', $zone));
            $tz = new \DateTimeZone($zone);
            $now = new \DateTime("now", $tz);

            $offset = $tz->getOffset($now);
            $hours = floor($offset / 3600);
            $minutes = abs(($offset % 3600) / 60);
            $sign = $offset >= 0 ? '+' : '-';
            $gmtOffsetName = sprintf('UTC%s%02d:%02d', $sign, abs($hours), $minutes);

            $timezoneData = [
                "tzName" => $zone,
                "zoneName" => $zone,
                "gmtOffset" => $offset,
                "abbreviation" => $now->format('T'),
                "gmtOffsetName" => $gmtOffsetName,
            ];

            $data['timezone'] = [$timezoneData];
            $data = array_merge($data, $request->safe()->except(['photo', 'timezone']));

            $country = Country::create($data);
            $this->uploadPhoto($request, $country, 'photo', 'countries');
            DB::commit();
            $message = __('main.messages.type_created', ['type' => __('main.country')]);
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', $message);
            }
            return redirect()->route('countries.index')->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('countries.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.country')]));
        }
    }

    public function edit($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.country')]));
        }
        $currencies = Currency::orderBy('code')->get();
        $languages = Language::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.countries.edit', get_defined_vars());
    }

    public function update(CountryUpdateRequest $request, $id)
    {
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.country')]));
        }
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data = array_merge($data, $request->safe()->except(['photo', 'timezone']));

            if ($request['state_id']) {
                $data['state_id'] = array_unique($data['state_id']);
            }
            if ($request['city_id']) {
                $data['city_id'] = array_unique($data['city_id']);
            }

            if ($request->input('timezone')) {
                $zone = $request->input('timezone');
                $zone = trim(preg_replace('/\s*\(.*\)$/', '', $zone));
                $tz = new \DateTimeZone($zone);
                $now = new \DateTime("now", $tz);

                $offset = $tz->getOffset($now);
                $hours = floor($offset / 3600);
                $minutes = abs(($offset % 3600) / 60);
                $sign = $offset >= 0 ? '+' : '-';
                $gmtOffsetName = sprintf('UTC%s%02d:%02d', $sign, abs($hours), $minutes);

                $timezoneData = [
                    "tzName" => $zone,
                    "zoneName" => $zone,
                    "gmtOffset" => $offset,
                    "abbreviation" => $now->format('T'),
                    "gmtOffsetName" => $gmtOffsetName,
                ];

                $data['timezone'] = [$timezoneData];
            }
            $country->update($data);
            if ($request->has('photo')) {
                $this->uploadPhoto($request, $country, 'photo', 'countries');
            }
            DB::commit();
            return redirect()->route('countries.index')->with('success', __('main.messages.type_updated', ['type' => __('main.country')]));
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.country')]));
        }
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.country')]));
        }
        $deleted = $country->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.country')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.country')]));
    }

    /**
     * Handle bulk edit actions for selected countries.
     */
    public function bulkEdit(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !$action) {
            return redirect()->back()->with('error', __('main.messages.select_countries_and_action'));
        }

        switch ($action) {
            case 'delete':
                $deleted = \App\Models\Country::whereIn('id', $ids)->delete();
                return redirect()->back()->with('success', __('main.messages.countries_deleted', ['count' => $deleted]));
            // يمكنك إضافة إجراءات أخرى هنا مثل التفعيل أو التعطيل
            default:
                return redirect()->back()->with('error', __('main.messages.unknown_action'));
        }
    }
}