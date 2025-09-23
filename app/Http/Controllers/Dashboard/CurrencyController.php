<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CreateCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::paginate(getPaginate());
        $totalCurrencies = Currency::count();
        return view('pages.dashboard.currencies.index', compact('currencies', 'totalCurrencies'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('pages.dashboard.currencies.create', compact('countries'));
    }

    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        $countries = Country::all();
        return view('pages.dashboard.currencies.edit', compact('currency', 'countries'));
    }

    public function store(CreateCurrencyRequest $request)
    {
        $validated = $request->validated();
        $currency = Currency::create($validated);

        if ($currency) {
            if ($request->has('save_and_add')) {
                return redirect()->route('currencies.create')->with('success', __('main.messages.currency_created'));
            }
            return redirect()->route('currencies.index')->with('success', __('main.messages.currency_created'));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.currency_creation_failed'));
    }

    public function update(UpdateCurrencyRequest $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $validated = $request->validated();
        $updated = $currency->update($validated);

        if ($updated) {
            return redirect()->route('currencies.index')->with('success', __('main.messages.currency_updated'));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.currency_updated_failed'));
    }

    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $deleted = $currency->delete();
        if ($deleted) {
            return redirect()->route('currencies.index')->with('success', __('main.messages.currency_deleted'));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.currency_deletion_failed'));
    }
}