<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Currency;
use App\Models\Restaurant;
use App\Models\Supplement;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supplement\StoreRequest;
use App\Http\Requests\Supplement\UpdateRequest;

class SupplementController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.supplements.index');
    }

    public function create()
    {
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.supplements.create', compact('currencies'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        if ($request->input('model_type') == 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') == 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
        $supplement = Supplement::create($validated);
        if ($supplement) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.supplement')]));
            }
            return redirect()->route('supplements.index')->withSuccess(__('messages.type_created', ['type' => __('main.supplement')]));
        }
        return redirect()->route('supplements.index')->withError(__('messages.type_creation_failed', ['type' => __('main.supplement')]));
    }

    public function show($id)
    {
        $supplement = Supplement::with('model')->find($id);
        if (!$supplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        }
        return view('pages.dashboard.supplements.show', compact('supplement'));
    }

    public function edit($id)
    {
        $supplement = Supplement::find($id);
        if (!$supplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        }
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.supplements.edit', compact('supplement', 'currencies'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $supplement = Supplement::find($id);
        if (!$supplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        }
        $validated = $request->validated();
        if ($request->input('model_type') === 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') === 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
        $updated = $supplement->update($validated);
        if ($updated) {
            return redirect()->route('supplements.index')->withSuccess(__('messages.type_updated', ['type' => __('main.supplement')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.supplement')]));
    }

    public function destroy($id)
    {
        $supplement = Supplement::find($id);
        if (!$supplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        }
        $deleted = $supplement->delete();
        return $deleted
            ? redirect()->route('supplements.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.supplement')]))
            : redirect()->route('supplements.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.supplement')]));
    }
}