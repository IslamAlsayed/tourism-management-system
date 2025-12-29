<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Http\Controllers\Controller;
use App\Http\Requests\Regions\RegionsCreateRequest;
use App\Http\Requests\Regions\RegionsUpdateRequest;

class RegionController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.regions.index');
    }

    public function create()
    {
        return view('pages.dashboard.regions.create');
    }

    public function store(RegionsCreateRequest $request)
    {
        $validated = $request->validated();
        $created = Region::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.region')]));
            }
            return redirect()->route('regions.index')->withSuccess(__('messages.type_created', ['type' => __('main.region')]));
        }

        return redirect()->route('regions.index')->withError(__('messages.type_creation_failed', ['type' => __('main.region')]));
    }

    public function show($id)
    {
        $region = Region::find($id);
        if (!$region) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        }
        return view('pages.dashboard.regions.show', compact('region'));
    }

    public function edit($id)
    {
        $region = Region::find($id);
        if (!$region) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        }
        return view('pages.dashboard.regions.edit', compact('region'));
    }

    public function update(RegionsUpdateRequest $request, $id)
    {
        $region = Region::find($id);
        if (!$region) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        }
        $validated = $request->validated();

        $updated = $region->update($validated);
        if ($updated) {
            return redirect()->route('regions.index')->withSuccess(__('messages.type_updated', ['type' => __('main.region')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.region')]));
    }

    public function destroy($id)
    {
        $region = Region::find($id);
        if (!$region) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        }
        $deleted = $region->delete();
        return $deleted
            ? redirect()->route('regions.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.region')]))
            : redirect()->route('regions.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.region')]));
    }
}