<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Countries\CreateCountriesRequest;
use App\Http\Requests\Countries\UpdateCountriesRequest;

class CountryController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.countries.index');
    }

    public function create()
    {
        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.countries.create', compact('currencies', 'regions'));
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
        $country = Country::find($id);
        if (!$country) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.country')]));
        }
        $currencies = Currency::orderBy('code')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.countries.edit', compact('country', 'currencies', 'regions'));
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