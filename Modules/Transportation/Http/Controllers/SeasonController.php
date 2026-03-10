<?php

namespace Modules\Transportation\Http\Controllers;

use Modules\Accommodations\Entities\Season;
use Modules\Transportation\Entities\Company;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Http\Requests\Season\StoreRequest;
use Modules\Accommodations\Http\Requests\Season\UpdateRequest;

class SeasonController extends Controller
{
    public function index()
    {
        return view('transportation::seasons.index');
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get(['id', 'name']);
        return view('transportation::seasons.create', compact('companies'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $modelType = $request->input('model_type');
        $polyConfig = config('polymorphic-selects');
        $validated['model_type'] = isset($polyConfig[$modelType]) ? $polyConfig[$modelType]['model'] : $modelType;
        $created = Season::create($validated);

        if ($created && $request->has('custom_fields')) {
            $created->saveCustomFields($request->custom_fields);
        }

        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.season')]))
                : redirect()->route('dashboard.transportation.seasons.index', ['type' => $request->input('type')])->with('success', __('messages.type_created', ['type' => __('main.season')])))
            : redirect()->route('dashboard.transportation.seasons.index', ['type' => $request->input('type')])->with('error', __('messages.type_creation_failed', ['type' => __('main.season')]));
    }

    public function show($id)
    {
        $season = Season::with((new Season)->getRelationshipNames())->find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        return view('transportation::seasons.show', compact('season'));
    }

    public function edit($id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        return view('transportation::seasons.edit', compact('season'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $modelType = $request->input('model_type');
        $polyConfig = config('polymorphic-selects');
        $validated['model_type'] = isset($polyConfig[$modelType]) ? $polyConfig[$modelType]['model'] : $modelType;
        $updated = $season->update($validated);

        if ($season && $request->has('custom_fields')) {
            $season->saveCustomFields($request->custom_fields);
        }

        return $updated
            ? redirect()->route('dashboard.transportation.seasons.index', ['type' => $request->input('type')])->withSuccess(__('messages.type_updated', ['type' => __('main.season')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.season')]));
    }

    public function destroy($id)
    {
        $season = Season::find($id);
        if (!$season)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.season')]));
        $deleted = $season->delete();
        return $deleted
            ? redirect()->route('dashboard.transportation.seasons.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.season')]))
            : redirect()->route('dashboard.transportation.seasons.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.season')]));
    }
}
