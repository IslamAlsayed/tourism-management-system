<?php

namespace Modules\Accommodations\Http\Controllers;

use Modules\Accommodations\Entities\Meal;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Http\Requests\Meal\StoreRequest;
use Modules\Accommodations\Http\Requests\Meal\UpdateRequest;

class MealController extends Controller
{
    public function index()
    {
        return view('accommodations::meals.index');
    }

    public function create()
    {
        return view('accommodations::meals.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $created = Meal::create($validated);

        if ($created && $request->has('custom_fields')) {
            $created->saveCustomFields($request->custom_fields);
        }

        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.meal')]))
                : redirect()->route('dashboard.accommodations.meals.index', ['type' => $request->input('type')])->with('success', __('messages.type_created', ['type' => __('main.meal')])))
            : redirect()->route('dashboard.accommodations.meals.index', ['type' => $request->input('type')])->with('error', __('messages.type_creation_failed', ['type' => __('main.meal')]));
    }

    public function show($id)
    {
        $meal = Meal::with((new Meal)->getRelationshipNames())->find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        return view('accommodations::meals.show', compact('meal'));
    }

    public function edit($id)
    {
        $meal = Meal::find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        return view('accommodations::meals.edit', compact('meal'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $meal = Meal::find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $updated = $meal->update($validated);

        if ($meal && $request->has('custom_fields')) {
            $meal->saveCustomFields($request->custom_fields);
        }

        return $updated
            ? redirect()->route('dashboard.accommodations.meals.index', ['type' => $request->input('type')])->withSuccess(__('messages.type_updated', ['type' => __('main.meal')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.meal')]));
    }

    public function destroy($id)
    {
        $meal = Meal::find($id);
        if (!$meal)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        $deleted = $meal->delete();
        return $deleted
            ? redirect()->route('dashboard.accommodations.meals.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.meal')]))
            : redirect()->route('dashboard.accommodations.meals.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.meal')]));
    }
}
