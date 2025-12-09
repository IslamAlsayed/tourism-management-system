<?php

namespace App\Http\Controllers\Dashboard\Accommodations;

use App\Models\MealType;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\Meal\StoreRequest;
use App\Http\Requests\Accommodations\Meal\UpdateRequest;

class MealTypeController extends Controller
{
    /**
     * Display a listing of meal types
     */
    public function index()
    {
        return view('pages.dashboard.accommodations.mealTypes.index');
    }

    /**
     * Show the form for creating a new meal type
     */
    public function create()
    {
        return view('pages.dashboard.accommodations.mealTypes.create');
    }

    /**
     * Store a newly created meal type
     */
    public function store(StoreRequest $request)
    {
        MealType::create($request->validated());

        return redirect()
            ->route('accommodations.mealTypes.index')
            ->with('success', 'تم إنشاء نوع الوجبة بنجاح!');
    }

    /**
     * Show the form for editing meal type
     */
    public function edit($id)
    {
        $meal = MealType::find($id);
        if (!$meal) {
            return redirect()->route('accommodations.mealTypes.index')->with('error', 'نوع الوجبة غير موجود!');
        }
        return view('pages.dashboard.accommodations.mealTypes.edit', compact('meal'));
    }

    /**
     * Update the specified meal type
     */
    public function update(UpdateRequest $request, $id)
    {
        $meal = MealType::find($id);
        if (!$meal) {
            return redirect()->route('accommodations.mealTypes.index')->with('error', 'نوع الوجبة غير موجود!');
        }
        $meal->update($request->validated());

        return redirect()
            ->route('accommodations.mealTypes.index')
            ->with('success', 'تم تحديث نوع الوجبة بنجاح!');
    }

    /**
     * Remove the specified meal type
     */
    public function destroy($id)
    {
        $meal = MealType::find($id);
        if (!$meal) {
            return redirect()->route('accommodations.mealTypes.index')->with('error', 'نوع الوجبة غير موجود!');
        }
        $meal->delete();

        return redirect()
            ->route('accommodations.mealTypes.index')
            ->with('success', 'تم حذف نوع الوجبة بنجاح!');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('pages.dashboard.accommodations.mealTypes.import');
    }
}
