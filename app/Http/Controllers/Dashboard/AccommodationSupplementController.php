<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Models\AccommodationSupplement;
use App\Http\Requests\AccommodationSupplement\StoreRequest;
use App\Http\Requests\AccommodationSupplement\UpdateRequest;

class AccommodationSupplementController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.accommodations-supplements.index');
    }

    public function create()
    {
        $accommodations = Accommodation::orderBy('name')->get();
        return view('pages.dashboard.accommodations-supplements.create', compact('accommodations'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $accommodationSupplement = AccommodationSupplement::create($validated);
        if ($accommodationSupplement) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.accommodation-supplement')]));
            }
            return redirect()->route('accommodations-supplements.index')->withSuccess(__('messages.type_created', ['type' => __('main.accommodation-supplement')]));
        }
        return redirect()->route('accommodations-supplements.index')->withError(__('messages.type_creation_failed', ['type' => __('main.accommodation-supplement')]));
    }

    public function show($id)
    {
        $accommodationSupplement = AccommodationSupplement::find($id);
        if (!$accommodationSupplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.accommodation-supplement')]));
        }
        return view('pages.dashboard.accommodations-supplements.show', compact('accommodationSupplement'));
    }

    public function edit($id)
    {
        $accommodationSupplement = AccommodationSupplement::find($id);
        if (!$accommodationSupplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.accommodation-supplement')]));
        }
        $accommodations = Accommodation::orderBy('name')->get();
        return view('pages.dashboard.accommodations-supplements.edit', compact('accommodationSupplement', 'accommodations'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $accommodationSupplement = AccommodationSupplement::find($id);
        if (!$accommodationSupplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.accommodation-supplement')]));
        }
        $validated = $request->validated();
        $updated = $accommodationSupplement->update($validated);
        if ($updated) {
            return redirect()->route('accommodations-supplements.index')->withSuccess(__('messages.type_updated', ['type' => __('main.accommodation-supplement')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.accommodation-supplement')]));
    }

    public function destroy($id)
    {
        $accommodationSupplement = AccommodationSupplement::find($id);
        if (!$accommodationSupplement) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.accommodation-supplement')]));
        }
        $deleted = $accommodationSupplement->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.accommodation-supplement')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.accommodation-supplement')]));
    }
}