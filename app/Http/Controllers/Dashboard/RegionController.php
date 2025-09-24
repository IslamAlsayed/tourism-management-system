<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use Illuminate\Http\Request;
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
                return redirect()->route('regions.create')->with('success', __('main.messages.type_created', ['type' => __('main.region')]));
            }
            return redirect()->route('regions.index')->with('success', __('main.messages.type_created', ['type' => __('main.region')]));
        }

        return redirect()->route('regions.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.region')]));
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        return view('pages.dashboard.regions.edit', compact('region'));
    }

    public function update(RegionsUpdateRequest $request, $id)
    {
        $region = Region::findOrFail($id);
        $validated = $request->validated();

        $updated = $region->update($validated);
        if ($updated) {
            return redirect()->route('regions.index')->with('success', __('main.messages.type_updated', ['type' => __('main.region')]));
        }

        return redirect()->route('regions.index')->with('error', __('main.messages.type_update_failed', ['type' => __('main.region')]));
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $deleted = $region->delete();
        if ($deleted) {
            return redirect()->route('regions.index')->with('success', __('main.messages.type_deleted', ['type' => __('main.region')]));
        }

        return redirect()->route('regions.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.region')]));
    }
}