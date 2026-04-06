<?php

namespace Modules\Cruises\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Cruises\Entities\Cruise;
use Illuminate\Http\Request;
use Modules\Cruises\Http\Requests\StoreCruiseRequest;
use Modules\Cruises\Http\Requests\UpdateCruiseRequest;

class CruiseController extends Controller
{
    public function index()
    {
        return view('cruises::vessels.index');
    }

    public function create()
    {
        $cities = \Modules\Geography\Entities\City::where('is_active', true)->get();
        $countries = \Modules\Geography\Entities\Country::where('is_active', true)->get();
        return view('cruises::vessels.create', compact('cities', 'countries'));
    }

    public function store(StoreCruiseRequest $request)
    {
        $validated = $request->validated();
        
        // Generate slug from name
        $slug = Str::slug($validated['name']);
        $count = Cruise::withTrashed()->where('slug', 'LIKE', $slug . '%')->count();
        $validated['slug'] = $count ? "{$slug}-{$count}" : $slug;

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_chartered'] = $request->has('is_chartered');
        
        // Assign company_id from authenticated user (or fallback to 1 if not available)
        $validated['company_id'] = auth()->id() ?? 1;

        $cruise = Cruise::create($validated);

        return redirect()->route('dashboard.cruises.index')
            ->with('success', __('main.created_successfully'));
    }

    public function show(Cruise $cruise)
    {
        return view('cruises::vessels.show', compact('cruise'));
    }

    public function edit(Cruise $cruise)
    {
        $cities = \Modules\Geography\Entities\City::where('is_active', true)->get();
        $countries = \Modules\Geography\Entities\Country::where('is_active', true)->get();
        return view('cruises::vessels.edit', compact('cruise', 'cities', 'countries'));
    }

    public function update(UpdateCruiseRequest $request, Cruise $cruise)
    {
        $validated = $request->validated();

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_chartered'] = $request->has('is_chartered');

        $cruise->update($validated);

        return redirect()->route('dashboard.cruises.index')
            ->with('success', __('main.updated_successfully'));
    }

    /**
     * Experimental standalone pricing page
     */
    public function pricing(Cruise $cruise)
    {
        return view('cruises::vessels.pricing', compact('cruise'));
    }
}
