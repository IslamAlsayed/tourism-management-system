<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\subregion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subregions\SubregionsCreateRequest;
use App\Http\Requests\Subregions\SubregionsUpdateRequest;

class SubregionController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.subregions.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.subregions.create', compact('regions'));
    }

    public function store(SubregionsCreateRequest $request)
    {
        $validated = $request->validated();
        $created = Subregion::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->route('subregions.create')->with('success', __('main.messages.type_created', ['type' => __('main.subregion')]));
            }
            return redirect()->route('subregions.index')->with('success', __('main.messages.type_created', ['type' => __('main.subregion')]));
        }

        return redirect()->route('subregions.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.subregion')]));
    }

    public function edit($id)
    {
        $subregion = Subregion::findOrFail($id);
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.subregions.edit', compact('subregion', 'regions'));
    }

    public function update(SubregionsUpdateRequest $request, $id)
    {
        $subregions = Subregion::findOrFail($id);
        $validated = $request->validated();

        $updated = $subregions->update($validated);
        if ($updated) {
            return redirect()->route('subregions.index')->with('success', __('main.messages.type_updated', ['type' => __('main.subregion')]));
        }

        return redirect()->route('subregions.index')->with('error', __('main.messages.type_update_failed', ['type' => __('main.subregion')]));
    }

    public function destroy($id)
    {
        $subregions = Subregion::findOrFail($id);
        $deleted = $subregions->delete();
        if ($deleted) {
            return redirect()->route('subregions.index')->with('success', __('main.messages.type_deleted', ['type' => __('main.subregion')]));
        }

        return redirect()->route('subregions.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.subregion')]));
    }
}