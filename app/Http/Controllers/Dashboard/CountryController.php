<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Subregion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Countries\CreateCountriesRequest;
use App\Http\Requests\Countries\UpdateCountriesRequest;
use App\Models\Restaurant;

class CountryController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.countries.index');
    }

    public function create()
    {
        $currencies = Currency::orderBy('code')->get();
        $languages = Language::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        // $subregions = Subregion::orderBy('name')->get();
        // $countries = Country::orderBy('name')->get();
        // $states = State::orderBy('name')->limit(15)->get();
        // $cities = City::orderBy('name')->limit(15)->get();
        return view('pages.dashboard.countries.create', get_defined_vars());
    }

    public function store(CreateCountriesRequest $request)
    {
        $validated = $request->validated();

        // Handle flag upload
        if ($request->hasFile('flag')) {
            $flagPath = $request->file('flag')->store('countries/flags', 'public');
            $validated['flag'] = $flagPath;
        }

        // Handle checkboxes
        $validated['is_active'] = $request->has('is_active');
        $validated['is_independent'] = $request->has('is_independent');
        $validated['is_developed'] = $request->has('is_developed');
        $validated['is_landlocked'] = $request->has('is_landlocked');

        $created = Country::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.country')]));
            }
            return redirect()->route('countries.index')->with('success', __('main.messages.type_created', ['type' => __('main.country')]));
        }

        return redirect()->route('countries.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.country')]));
    }

    public function edit($id)
    {
        // Restaurant::with('country.state.city.region.subregions')->chunk(1000, function ($restaurants) {
        //     foreach ($restaurants as $key => $restaurant) {
        //         $country = $restaurant->country;
        //         if (!$country) {
        //             echo ++$key . "❌ No country found for restaurant: {$restaurant->name}<br/>";
        //             continue;
        //         }

        //         $state = $country->state;
        //         if (!$state) {
        //             echo ++$key . "❌ No state found for country: {$country->name}<br/>";
        //             continue;
        //         }

        //         $city = $state->city;
        //         if (!$city) {
        //             echo ++$key . "❌ No city found for state: {$state->name}<br/>";
        //             continue;
        //         }

        //         $region = $country->region;
        //         if (!$region) {
        //             echo ++$key . "❌ No region found for country: {$country->name}<br/>";
        //             continue;
        //         }

        //         $subregion = $region->subregions()->first();
        //         if (!$subregion) {
        //             echo ++$key . "❌ No subregion found for region: {$region->name} (Country: {$country->name})<br/>";
        //             continue;
        //         }

        //         $updated = false;

        //         if (!$restaurant->region_id || $restaurant->region_id != $region->id) {
        //             $restaurant->region_id = $region->id;
        //             $updated = true;
        //         }

        //         if (!$restaurant->subregion_id || $restaurant->subregion_id != $subregion->id) {
        //             $restaurant->subregion_id = $subregion->id;
        //             $updated = true;
        //         }

        //         if (!$restaurant->country_id || $restaurant->country_id != $country->id) {
        //             $restaurant->country_id = $country->id;
        //             $updated = true;
        //         }

        //         if (!$restaurant->state_id || $restaurant->state_id != $state->id) {
        //             $restaurant->state_id = $state->id;
        //             $updated = true;
        //         }

        //         if (!$restaurant->city_id || $restaurant->city_id != $city->id) {
        //             $restaurant->city_id = $city->id;
        //             $updated = true;
        //         }

        //         if ($updated) {
        //             $restaurant->save();
        //             echo ++$key . "✅ Updated restaurant {$restaurant->id} with region_id: $restaurant->region_id, subregion_id: $restaurant->subregion_id, country_id: $restaurant->country_id, state_id: $restaurant->state_id<br/>";
        //         } else {
        //             echo ++$key . "✅ restaurant already up-to-date: {$restaurant->id}<br/>";
        //         }
        //     }
        // });

        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.country')]));
        }
        $currencies = Currency::orderBy('code')->get();
        $languages = Language::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.countries.edit', get_defined_vars());
    }

    public function update(UpdateCountriesRequest $request, $id)
    {
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.country')]));
        }
        $validated = $request->validated();

        $updated = $country->update($validated);
        if ($updated) {
            return redirect()->route('countries.index')->with('success', __('main.messages.type_updated', ['type' => __('main.country')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_updated_failed', ['type' => __('main.country')]));
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