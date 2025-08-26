<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::paginate(10);
        $totalCountries = Country::count();
        return view('pages.dashboard.countries.index', compact('countries', 'totalCountries'));
    }

    public function create()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.countries.create', compact('currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code_iso2' => 'required|string|max:2|unique:countries,code_iso2',
            'code_iso3' => 'nullable|string|max:3',
            'phone_code' => 'nullable|string|max:10',
            'capital' => 'nullable|string|max:255',
            'currency_id' => 'nullable|exists:currencies,id',
            'population' => 'nullable|integer',
            'area' => 'nullable|numeric',
            'continent' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'timezone' => 'nullable|string|max:255',
            'languages' => 'nullable|string',
            'description' => 'nullable|string',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
            'is_independent' => 'boolean',
            'is_developed' => 'boolean',
            'is_landlocked' => 'boolean',
        ]);

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

        Country::create($validated);

        if ($request->has('save_and_add')) {
            return redirect()->route('countries.create')->with('success', 'تم حفظ البلد بنجاح! يمكنك إضافة بلد آخر.');
        }

        return redirect()->route('countries.index')->with('success', 'تم إضافة البلد بنجاح!');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('pages.dashboard.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
        ]);

        $updated = $country->update($validated);
        if ($updated) {
            return redirect()->route('countries.index')->with('success', 'Country updated successfully');
        }

        return redirect()->route('countries.index')->with('error', 'Country update failed');
    }

    /**
     * Handle bulk edit actions for selected countries.
     */
    public function bulkEdit(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !$action) {
            return redirect()->back()->with('error', 'يرجى تحديد الدول والإجراء المطلوب.');
        }

        switch ($action) {
            case 'delete':
                $deleted = \App\Models\Country::whereIn('id', $ids)->delete();
                return redirect()->back()->with('success', 'تم حذف ' . $deleted . ' دولة بنجاح.');
            // يمكنك إضافة إجراءات أخرى هنا مثل التفعيل أو التعطيل
            default:
                return redirect()->back()->with('error', 'إجراء غير معروف.');
        }
    }
}
