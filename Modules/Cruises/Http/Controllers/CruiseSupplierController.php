<?php

namespace Modules\Cruises\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Cruises\Entities\CruiseSupplier;
use Modules\Cruises\Http\Requests\StoreSupplierRequest;
use Modules\Cruises\Http\Requests\UpdateSupplierRequest;

class CruiseSupplierController extends Controller
{
    public function index()
    {
        return view('cruises::suppliers.index');
    }

    public function create()
    {
        $cities = \Modules\Geography\Entities\City::where('is_active', true)->get();
        return view('cruises::suppliers.create', compact('cities'));
    }

    public function store(StoreSupplierRequest $request)
    {
        CruiseSupplier::create($request->validated() + [
            'company_id' => auth()->user()->company_id ?? auth()->id() ?? 1,
            'is_active'  => $request->has('is_active') ? $request->is_active : 1,
        ]);

        return redirect()->route('dashboard.cruises.suppliers.index')
            ->with('success', __('main.created_successfully'));
    }

    public function edit(CruiseSupplier $supplier)
    {
        $cities = \Modules\Geography\Entities\City::where('is_active', true)->get();
        return view('cruises::suppliers.edit', compact('supplier', 'cities'));
    }

    public function update(UpdateSupplierRequest $request, CruiseSupplier $supplier)
    {
        $supplier->update($request->validated() + [
            'is_active' => $request->has('is_active') ? $request->is_active : $supplier->is_active,
        ]);

        return redirect()->route('dashboard.cruises.suppliers.index')
            ->with('success', __('main.updated_successfully'));
    }

    public function destroy(CruiseSupplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', __('main.deleted_successfully'));
    }
}
