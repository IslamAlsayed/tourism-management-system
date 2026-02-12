<?php

namespace Modules\Geography\Http\Controllers;

use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\Subregion;
use Illuminate\Routing\Controller;
use Modules\Geography\Http\Requests\Subregion\StoreRequest;
use Modules\Geography\Http\Requests\Subregion\UpdateRequest;

class SubregionController extends Controller
{
    public function index()
    {
        return view('geography::subregions.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('geography::subregions.create', compact('regions'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Subregion::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.subregion')]))
                : redirect()->route('dashboard.geography.subregions.index')->with('success', __('messages.type_created', ['type' => __('main.subregion')])))
            : redirect()->route('dashboard.geography.subregions.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.subregion')]));
    }

    public function show($id)
    {
        $subregion = Subregion::with((new Subregion)->getRelationshipNames())->find($id);
        if (!$subregion)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregion')]));
        return view('geography::subregions.show', compact('subregion'));
    }

    public function edit($id)
    {
        $subregion = Subregion::find($id);
        if (!$subregion)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregion')]));
        $regions = Region::orderBy('name')->get();
        return view('geography::subregions.edit', compact('subregion', 'regions'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $subregions = Subregion::find($id);
        if (!$subregions) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregions')]));
        }
        $validated = $request->validated();
        $updated = $subregions->update($validated);
        return $updated
            ? redirect()->route('dashboard.geography.subregions.index')->withSuccess(__('messages.type_updated', ['type' => __('main.subregion')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.subregion')]));
    }

    public function destroy($id)
    {
        $subregions = Subregion::find($id);
        if (!$subregions) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.subregions')]));
        }
        $deleted = $subregions->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.subregions.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.subregion')]))
            : redirect()->route('dashboard.geography.subregions.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.subregion')]));
    }
}
