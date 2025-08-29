<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Countries\CreateCountriesRequest;
use App\Http\Requests\Countries\UpdateCountriesRequest;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::with('currency')->paginate(10);
        $totalCountries = Country::count();
        return view('pages.dashboard.countries.index', compact('countries', 'totalCountries'));
    }

    public function create()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.countries.create', compact('currencies'));
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
                return redirect()->route('countries.create')->with('success', __('main.messages.country_created'));
            }
            return redirect()->route('countries.index')->with('success', __('main.messages.country_created'));
        }

        return redirect()->route('countries.index')->with('error', __('main.messages.country_creation_failed'));
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.countries.edit', compact('country', 'currencies'));
    }

    public function update(UpdateCountriesRequest $request, $id)
    {
        $country = Country::findOrFail($id);
        $validated = $request->validated();

        $updated = $country->update($validated);
        if ($updated) {
            return redirect()->route('countries.index')->with('success', __('main.messages.country_updated'));
        }

        return redirect()->route('countries.index')->with('error', __('main.messages.country_updated_failed'));
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $deleted = $country->delete();
        if ($deleted) {
            return redirect()->route('countries.index')->with('success', __('main.messages.country_deleted'));
        }

        return redirect()->route('countries.index')->with('error', __('main.messages.country_deletion_failed'));
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