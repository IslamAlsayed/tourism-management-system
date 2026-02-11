<?php

namespace Modules\Accommodations\Http\Controllers;

use Modules\Restaurants\Entities\Restaurant;
use Modules\Accommodations\Entities\Supplement;
use Modules\Accommodations\Entities\Accommodation;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Http\Requests\Supplement\StoreRequest;
use Modules\Accommodations\Http\Requests\Supplement\UpdateRequest;

class SupplementController extends Controller
{
    public function index()
    {
        return view('accommodations::supplements.index');
    }

    public function create()
    {
        return view('accommodations::supplements.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $created = Supplement::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.supplement')]))
                : redirect()->route('dashboard.accommodations.supplements.index', ['type' => $request->input('type')])->with('success', __('messages.type_created', ['type' => __('main.supplement')])))
            : redirect()->route('dashboard.accommodations.supplements.index', ['type' => $request->input('type')])->with('error', __('messages.type_creation_failed', ['type' => __('main.supplement')]));
    }

    public function show($id)
    {
        $supplement = Supplement::with((new Supplement)->getRelationshipNames())->find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        return view('accommodations::supplements.show', compact('supplement'));
    }

    public function edit($id)
    {
        $supplement = Supplement::find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        return view('accommodations::supplements.edit', compact('supplement'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $supplement = Supplement::find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $updated = $supplement->update($validated);
        return $updated
            ? redirect()->route('dashboard.accommodations.supplements.index', ['type' => $request->input('type')])->withSuccess(__('messages.type_updated', ['type' => __('main.supplement')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.supplement')]));
    }

    public function destroy($id)
    {
        $supplement = Supplement::find($id);
        if (!$supplement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.supplement')]));
        $deleted = $supplement->delete();
        return $deleted
            ? redirect()->route('dashboard.accommodations.supplements.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.supplement')]))
            : redirect()->route('dashboard.accommodations.supplements.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.supplement')]));
    }
}
