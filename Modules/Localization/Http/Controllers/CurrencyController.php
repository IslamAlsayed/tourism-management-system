<?php

namespace Modules\Localization\Http\Controllers;

use Modules\Localization\Entities\Currency;
use Illuminate\Routing\Controller;
use Modules\Localization\Http\Requests\Currency\StoreRequest;
use Modules\Localization\Http\Requests\Currency\UpdateRequest;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('localization::currencies.index');
    }

    public function create()
    {
        return view('localization::currencies.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        
        if (!empty($validated['is_base_currency'])) {
            Currency::where('id', '!=', 0)->update(['is_base_currency' => false]);
            $validated['exchange_rate'] = 1.0;
        }

        $created = Currency::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.currency')]))
                : redirect()->route('dashboard.localization.currencies.index')->with('success', __('messages.type_created', ['type' => __('main.currency')])))
            : redirect()->route('dashboard.localization.currencies.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.currency')]));
    }

    public function show($id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.currency')]));
        return view('localization::currencies.show', compact('currency'));
    }

    public function edit($id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.currency')]));
        return view('localization::currencies.edit', compact('currency'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.currency')]));
            
        $validated = $request->validated();
        
        if (!empty($validated['is_base_currency'])) {
            Currency::where('id', '!=', $id)->update(['is_base_currency' => false]);
            $validated['exchange_rate'] = 1.0;
        }

        $updated = $currency->update($validated);
        return $updated
            ? redirect()->route('dashboard.localization.currencies.index')->with('success', __('messages.type_updated', ['type' => __('main.currency')]))
            : redirect()->back()->with('error', __('messages.type_update_failed', ['type' => __('main.currency')]));
    }

    public function destroy($id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.currency')]));
        $deleted = $currency->delete();
        return $deleted
            ? redirect()->route('dashboard.localization.currencies.index')->with('success', __('messages.type_deleted', ['type' => __('main.currency')]))
            : redirect()->route('dashboard.localization.currencies.index')->with('error', __('messages.type_deletion_failed', ['type' => __('main.currency')]));
    }
}
