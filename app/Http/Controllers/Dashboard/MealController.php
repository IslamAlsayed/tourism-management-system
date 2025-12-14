<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Meal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\Meal\StoreRequest;
use App\Http\Requests\Accommodations\Meal\UpdateRequest;

class MealController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.meals.index');
    }

    public function create()
    {
        return view('pages.dashboard.meals.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $meal = Meal::create($validated);
        if ($meal) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.meal')]));
            }
            return redirect()->route('meals.index')->withSuccess(__('messages.type_created', ['type' => __('main.meal')]));
        }
        return redirect()->route('meals.index')->withError(__('messages.type_creation_failed', ['type' => __('main.meal')]));
    }

    public function show($id)
    {
        $meal = Meal::with(['mealRates'])->find($id);
        if (!$meal) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        }
        return view('pages.dashboard.meals.show', compact('meal'));
    }

    public function edit($id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        }
        return view('pages.dashboard.meals.edit', compact('meal'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        }
        $validated = $request->validated();
        $updated = $meal->update($validated);
        if ($updated) {
            return redirect()->route('meals.index')->withSuccess(__('messages.type_updated', ['type' => __('main.meal')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.meal')]));
    }

    public function destroy($id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        }
        $deleted = $meal->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.meal')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.meal')]));
    }
}