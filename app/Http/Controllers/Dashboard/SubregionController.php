<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\Subregion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subregion\StoreRequest;
use App\Http\Requests\Subregion\UpdateRequest;

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

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Subregion::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.subregion')]));
            }
            return redirect()->route('subregions.index')->withSuccess(__('messages.type_created', ['type' => __('main.subregion')]));
        }

        return redirect()->route('subregions.index')->withError(__('messages.type_creation_failed', ['type' => __('main.subregion')]));
    }

    public function show($id)
    {
        $subregion = Subregion::with('region')->find($id);
        if (!$subregion) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregion')]));
        }
        return view('pages.dashboard.subregions.show', compact('subregion'));
    }

    public function edit($id)
    {
        $subregion = Subregion::find($id);
        if (!$subregion) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregion')]));
        }
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.subregions.edit', compact('subregion', 'regions'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $subregions = Subregion::find($id);
        if (!$subregions) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregions')]));
        }
        $validated = $request->validated();

        $updated = $subregions->update($validated);
        if ($updated) {
            return redirect()->route('subregions.index')->withSuccess(__('messages.type_updated', ['type' => __('main.subregion')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.subregion')]));
    }

    public function destroy($id)
    {
        $subregions = Subregion::find($id);
        if (!$subregions) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregions')]));
        }
        $deleted = $subregions->delete();
        if ($deleted) {
            return redirect()->route('subregions.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.subregion')]));
        }

        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.subregion')]));
    }
}