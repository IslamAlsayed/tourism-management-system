<?php

namespace Modules\Geography\Http\Controllers;

use Modules\Geography\Entities\Region;
use Illuminate\Routing\Controller;
use Modules\Geography\Http\Requests\Regions\StoreRequest;
use Modules\Geography\Http\Requests\Regions\UpdateRequest;

class RegionController extends Controller
{
    public function index()
    {
        return view('geography::regions.index');
    }

    public function create()
    {
        return view('geography::regions.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Region::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.region')]))
                : redirect()->route('dashboard.geography.regions.index')->with('success', __('messages.type_created', ['type' => __('main.region')])))
            : redirect()->route('dashboard.geography.regions.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.region')]));
    }

    public function show($id)
    {
        $region = Region::find($id);
        if (!$region)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        return view('geography::regions.show', compact('region'));
    }

    public function edit($id)
    {
        $region = Region::find($id);
        if (!$region)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        return view('geography::regions.edit', compact('region'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $region = Region::find($id);
        if (!$region)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        $validated = $request->validated();

        $updated = $region->update($validated);
        return $updated
            ? redirect()->route('dashboard.geography.regions.index')->withSuccess(__('messages.type_updated', ['type' => __('main.region')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.region')]));
    }

    public function destroy($id)
    {
        $region = Region::find($id);
        if (!$region)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.region')]));
        $deleted = $region->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.regions.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.region')]))
            : redirect()->route('dashboard.geography.regions.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.region')]));
    }
}