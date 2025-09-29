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
        return view('pages.dashboard.currencies.index');
    }

    public function create()
    {
        $countries = Country::all();
        return view('pages.dashboard.currencies.create', compact('countries'));
    }

    public function edit($id)
    {
        $currency = Currency::find($id);
        if (!$currency) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.currency')]));
        }
        $countries = Country::all();
        return view('pages.dashboard.currencies.edit', compact('currency', 'countries'));
    }

    public function store(CreateCurrencyRequest $request)
    {
        $validated = $request->validated();
        $currency = Currency::create($validated);

        if ($currency) {
            if ($request->has('save_and_add')) {
                return redirect()->route('currencies.create')->with('success', __('main.messages.type_created', ['type' => __('main.currency')]));
            }
            return redirect()->route('currencies.index')->with('success', __('main.messages.type_created', ['type' => __('main.currency')]));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.currency')]));
    }

    public function update(UpdateCurrencyRequest $request, $id)
    {
        $currency = Currency::find($id);
        if (!$currency) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.currency')]));
        }
        $validated = $request->validated();
        $updated = $currency->update($validated);

        if ($updated) {
            return redirect()->route('currencies.index')->with('success', __('main.messages.type_updated', ['type' => __('main.currency')]));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.type_updated_failed', ['type' => __('main.currency')]));
    }

    public function destroy($id)
    {
        $currency = Currency::find($id);
        if (!$currency) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.currency')]));
        }
        $deleted = $currency->delete();
        if ($deleted) {
            return redirect()->route('currencies.index')->with('success', __('main.messages.type_deleted', ['type' => __('main.currency')]));
        }

        return redirect()->route('currencies.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.currency')]));
    }
}