<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Meal;
use App\Models\Season;
use App\Models\Currency;
use App\Models\Restaurant;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Meal\StoreRequest;
use App\Http\Requests\Meal\UpdateRequest;

class MealController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.meals.index');
    }

    public function create()
    {
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.meals.create', compact('currencies'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        if ($request->input('model_type') == 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') == 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
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
        $meal = Meal::with(['model', 'currency'])->find($id);
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
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.meals.edit', compact('meal', 'currencies'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.meal')]));
        }
        $validated = $request->validated();
        if ($request->input('model_type') === 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') === 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
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
        return $deleted
            ? redirect()->route('meals.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.meal')]))
            : redirect()->route('meals.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.meal')]));
    }
}