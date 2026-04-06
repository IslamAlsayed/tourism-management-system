<?php

namespace Modules\Cruises\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Cruises\Entities\CruiseCabinCategory;
use Modules\Cruises\Http\Requests\StoreCabinCategoryRequest;
use Modules\Cruises\Http\Requests\UpdateCabinCategoryRequest;

class CabinCategoryController extends Controller
{
    public function index()
    {
        return view('cruises::categories.index');
    }

    public function create()
    {
        return view('cruises::categories.create');
    }

    public function store(StoreCabinCategoryRequest $request)
    {
        CruiseCabinCategory::create($request->validated() + [
            'is_active' => $request->has('is_active') ? $request->is_active : 1,
            'company_id' => auth()->user()->company_id ?? auth()->id() ?? 1,
        ]);

        return redirect()->route('dashboard.cruises.categories.index')
            ->with('success', __('main.created_successfully'));
    }

    public function edit(CruiseCabinCategory $category)
    {
        return view('cruises::categories.edit', compact('category'));
    }

    public function update(UpdateCabinCategoryRequest $request, CruiseCabinCategory $category)
    {
        $category->update($request->validated() + ['is_active' => $request->has('is_active') ? $request->is_active : $category->is_active]);

        return redirect()->route('dashboard.cruises.categories.index')
            ->with('success', __('main.updated_successfully'));
    }

    public function destroy(CruiseCabinCategory $category)
    {
        $category->delete();
        return back()->with('success', __('main.deleted_successfully'));
    }
}
