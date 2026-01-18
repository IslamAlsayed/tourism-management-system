<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\StoreRequest;
use App\Http\Requests\Currency\UpdateRequest;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.currencies.index');
    }

    public function create()
    {
        return view('pages.dashboard.currencies.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Currency::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.currency')]))
                : redirect()->route('currencies.index')->with('success', __('messages.type_created', ['type' => __('main.currency')])))
            : redirect()->route('currencies.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.currency')]));
    }

    public function show($id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.currency')]));
        return view('pages.dashboard.currencies.show', compact('currency'));
    }

    public function edit($id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.currency')]));
        return view('pages.dashboard.currencies.edit', compact('currency'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.currency')]));
        $validated = $request->validated();
        $updated = $currency->update($validated);
        return $updated
            ? redirect()->route('currencies.index')->withSuccess(__('messages.type_updated', ['type' => __('main.currency')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.currency')]));
    }

    public function destroy($id)
    {
        $currency = Currency::find($id);
        if (!$currency)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.currency')]));
        $deleted = $currency->delete();
        return $deleted
            ? redirect()->route('currencies.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.currency')]))
            : redirect()->route('currencies.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.currency')]));
    }
}