<?php

namespace Modules\Geography\Http\Controllers;

use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Language;
use Modules\Geography\Entities\CityState;
use Illuminate\Http\Request;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use App\Http\Requests\Country\StoreRequest;
use App\Http\Requests\Country\UpdateRequest;

class CountryController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('geography::countries.index');
    }

    public function create()
    {
        $languages = Language::orderBy('name')->get();
        return view('geography::countries.create', compact('languages'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        unset($data['state_id'], $data['city_id']);
        $country = Country::create($data);
        if (!$country)
            return redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_creation_failed', ['type' => __('main.country')]));
        $this->uploadPhoto($request, $country, 'photo', 'countries');
        // States
        $stateIds = [];
        if ($request->boolean('all_states')) {
            $stateIds = State::where('country_id', $country->id)->pluck('id')->toArray();
        } elseif ($request->filled('state_id')) {
            $stateIds = array_unique((array) $request->input('state_id'));
        }
        $country->states()->sync($stateIds);
        // Cities
        $cityIds = [];
        if ($request->boolean('all_cities')) {
            $cityIds = City::whereIn('state_id', $stateIds)->pluck('id')->toArray();
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $country->cities()->sync($cityIds);
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.country')]))
            : redirect()->route('dashboard.geography.countries.index')->withSuccess(__('messages.type_created', ['type' => __('main.country')]));
    }

    public function show($id)
    {
        $country = Country::with((new Country)->getRelationshipNames())->find($id);
        if (!$country)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        return view('geography::countries.show', compact('country'));
    }

    public function edit($id)
    {
        $country = Country::find($id);
        if (!$country)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        $languages = Language::orderBy('name')->get();
        return view('geography::countries.edit', compact('country', 'languages'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $country = Country::find($id);
        if (!$country)
            return redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_creation_failed', ['type' => __('main.country')]));
        $data = $request->validated();
        unset($data['state_id'], $data['city_id']);
        // States
        $stateIds = [];
        if ($request->boolean('all_states')) {
            $stateIds = State::where('country_id', $country->id)->pluck('id')->toArray();
        } elseif ($request->filled('state_id')) {
            $stateIds = array_unique((array) $request->input('state_id'));
        }
        $country->states()->sync($stateIds);
        // Cities
        $cityIds = [];
        if ($request->boolean('all_cities')) {
            $cityIds = array_unique(CityState::whereIn('state_id', $stateIds)->pluck('city_id')->toArray());
        } elseif ($request->filled('city_id')) {
            $cityIds = array_unique((array) $request->input('city_id'));
        }
        $country->cities()->sync($cityIds);
        $updated = $country->update($data);
        return $updated
            ? redirect()->route('dashboard.geography.countries.index')->withSuccess(__('messages.type_updated', ['type' => __('main.country')]))
            : redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_update_failed', ['type' => __('main.country')]));
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        if (!$country)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        $deleted = $country->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.countries.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.country')]))
            : redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.country')]));
    }

    public function bulkEdit(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !$action) {
            return redirect()->back()->withError(__('messages.select_countries_and_action'));
        }

        switch ($action) {
            case 'delete':
                $deleted = Country::whereIn('id', $ids)->delete();
                return redirect()->back()->withSuccess(__('messages.countries_deleted', ['count' => $deleted]));
            default:
                return redirect()->back()->withError(__('messages.unknown_action'));
        }
    }
}
