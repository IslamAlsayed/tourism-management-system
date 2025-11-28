<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Timezone;
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
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.countries.create', compact('currencies', 'languages', 'regions', 'timezones'));
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

            $stateIds = $data['state_id'] ?? [];
            $cityIds = $data['city_id'] ?? [];

            if (!empty($data['all_states']) && $data['all_states'] == 1) {
                $stateIds = State::where('country_id', $data['country_id'])->pluck('id')->toArray();
            }

            if (!empty($data['all_cities']) && $data['all_cities'] == 1) {
                if (!empty($data['all_states']) && $data['all_states'] == 1) {
                    $cityIds = City::where('country_id', $data['country_id'])->pluck('id')->toArray();
                } else {
                    $cityIds = City::whereIn('state_id', $stateIds)->pluck('id')->toArray();
                }
            }

            $data['state_id'] = !empty($stateIds) ? implode(',', $stateIds) : null;
            $data['city_id'] = !empty($cityIds) ? implode(',', $cityIds) : null;

            unset($data['_token'], $data['save_and_add']);
            $data = array_merge($data, $request->safe()->except(['photo']));
            $country = Country::create($data);
            $this->uploadPhoto($request, $country, 'photo', 'countries');
            DB::commit();
            $message = __('messages.type_created', ['type' => __('main.country')]);
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess($message);
            }
            return redirect()->route('countries.index')->withSuccess($message);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('countries.index')->withError(__('messages.type_creation_failed', ['type' => __('main.country')]));
        }
    }

    public function edit($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        }
        $currencies = Currency::orderBy('code')->get();
        $languages = Language::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.countries.edit', compact('country', 'currencies', 'languages', 'regions', 'timezones'));
    }

    public function update(CountryUpdateRequest $request, $id)
    {
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        }
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data = array_merge($data, $request->safe()->except(['photo']));

            if ($request['state_id']) {
                $data['state_id'] = array_unique($data['state_id']);
            }
            if ($request['city_id']) {
                $data['city_id'] = array_unique($data['city_id']);
            }
            $country->update($data);
            if ($request->has('photo')) {
                $this->uploadPhoto($request, $country, 'photo', 'countries');
            }
            DB::commit();
            return redirect()->route('countries.index')->withSuccess(__('messages.type_updated', ['type' => __('main.country')]));
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.country')]));
        }
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        }
        $deleted = $country->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.country')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.country')]));
    }

    /**
     * Handle bulk edit actions for selected countries.
     */
    public function bulkEdit(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !$action) {
            return redirect()->back()->withError(__('messages.select_countries_and_action'));
        }

        switch ($action) {
            case 'delete':
                $deleted = \App\Models\Country::whereIn('id', $ids)->delete();
                return redirect()->back()->withSuccess(__('messages.countries_deleted', ['count' => $deleted]));
            default:
                return redirect()->back()->withError(__('messages.unknown_action'));
        }
    }
}