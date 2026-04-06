<?php

namespace Modules\Cruises\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Cruises\Entities\CruiseSeason;
use Modules\Cruises\Http\Requests\StoreCruiseSeasonRequest;
use Modules\Cruises\Http\Requests\UpdateCruiseSeasonRequest;

class CruiseSeasonController extends Controller
{
    public function index()
    {
        return view('cruises::seasons.index');
    }

    public function create()
    {
        return view('cruises::seasons.create');
    }

    public function store(StoreCruiseSeasonRequest $request)
    {
        CruiseSeason::create($request->validated() + ['is_active' => $request->has('is_active') ? $request->is_active : 1]);

        return redirect()->route('dashboard.cruises.seasons.index')
            ->with('success', __('main.created_successfully'));
    }

    public function edit(CruiseSeason $season)
    {
        return view('cruises::seasons.edit', compact('season'));
    }

    public function update(UpdateCruiseSeasonRequest $request, CruiseSeason $season)
    {
        $season->update($request->validated() + ['is_active' => $request->has('is_active') ? $request->is_active : $season->is_active]);

        return redirect()->route('dashboard.cruises.seasons.index')
            ->with('success', __('main.updated_successfully'));
    }

    public function destroy(CruiseSeason $season)
    {
        $season->delete();
        return back()->with('success', __('main.deleted_successfully'));
    }
}
