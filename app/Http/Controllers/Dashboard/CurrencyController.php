<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Country;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::paginate(10);
        $totalCurrencies = Currency::count();
        return view('pages.dashboard.currencies.index', compact('currencies', 'totalCurrencies'));
    }

    public function create()
    {
        $countries = Country::orderBy('name_ar')->get();
        return view('pages.dashboard.currencies.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:currencies,code',
            'symbol' => 'required|string|max:5',
            'numeric_code' => 'nullable|integer|unique:currencies,numeric_code',
            'exchange_rate' => 'required|numeric|min:0',
            'decimal_places' => 'integer|min:0|max:4',
            'countries' => 'array',
            'countries.*' => 'exists:countries,id',
            'type' => 'in:fiat,crypto,commodity',
            'subunit_name' => 'nullable|string|max:100',
            'subunit_ratio' => 'nullable|integer|min:1',
            'symbol_position' => 'in:before,after',
            'thousand_separator' => 'nullable|string|max:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_crypto' => 'boolean',
            'auto_update_rate' => 'boolean',
            'is_base_currency' => 'boolean',
        ]);

        // Handle checkboxes
        $validated['is_active'] = $request->has('is_active');
        $validated['is_crypto'] = $request->has('is_crypto');
        $validated['auto_update_rate'] = $request->has('auto_update_rate');
        $validated['is_base_currency'] = $request->has('is_base_currency');

        $currency = Currency::create($validated);

        // Attach countries if provided
        if ($request->has('countries')) {
            $currency->countries()->attach($request->countries);
        }

        if ($request->has('save_and_add')) {
            return redirect()->route('currencies.create')->with('success', 'تم حفظ العملة بنجاح! يمكنك إضافة عملة أخرى.');
        }

        return redirect()->route('currencies.index')->with('success', 'تم إضافة العملة بنجاح!');
    }

    public function rates()
    {
        return view('pages.dashboard.currencies.rates');
    }

    public function updateRates(Request $request)
    {
        // Logic for updating exchange rates
        return redirect()->route('currencies.rates')->with('success', 'تم تحديث أسعار الصرف بنجاح!');
    }

    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        return view('pages.dashboard.currencies.edit', compact('currency'));
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'symbol' => 'required|string|max:5',
        ]);

        $updated = $currency->update($validated);
        if ($updated) {
            return redirect()->route('currencies.index')->with('success', 'Currency updated successfully');
        }

        return redirect()->route('currencies.index')->with('error', 'Currency update failed');
    }
}
