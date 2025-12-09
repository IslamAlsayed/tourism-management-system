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
        Meal::create($request->validated());
        return redirect()->route('meals.index')->with('success', 'تم إنشاء نوع الوجبة بنجاح!');
    }

    public function edit($id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return redirect()->route('meals.index')->with('error', 'نوع الوجبة غير موجود!');
        }
        return view('pages.dashboard.meals.edit', compact('meal'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return redirect()->route('meals.index')->with('error', 'نوع الوجبة غير موجود!');
        }
        $meal->update($request->validated());
        return redirect()->route('meals.index')->with('success', 'تم تحديث نوع الوجبة بنجاح!');
    }

    public function destroy($id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return redirect()->route('meals.index')->with('error', 'نوع الوجبة غير موجود!');
        }
        $meal->delete();
        return redirect()->route('meals.index')->with('success', 'تم حذف نوع الوجبة بنجاح!');
    }

    public function importForm()
    {
        return view('pages.dashboard.meals.import');
    }
}