<?php

namespace App\Http\Controllers\Dashboard\Accommodations;

use App\Models\Season;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\Season\StoreRequest;
use App\Http\Requests\Accommodations\Season\UpdateRequest;

class SeasonController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.accommodations.seasons.index');
    }

    public function create()
    {
        $accommodations = Accommodation::orderBy('name')->get();
        return view('pages.dashboard.accommodations.seasons.create', compact('accommodations'));
    }

    public function store(StoreRequest $request)
    {
        Season::create($request->validated());
        return redirect()->route('accommodations.seasons.index')->with('success', 'تم إنشاء الموسم بنجاح!');
    }

    public function edit($id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->route('accommodations.seasons.index')->with('error', 'الموسم غير موجود!');
        }
        $accommodations = Accommodation::orderBy('name')->get();
        return view('pages.dashboard.accommodations.seasons.edit', compact('season', 'accommodations'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->route('accommodations.seasons.index')->with('error', 'الموسم غير موجود!');
        }
        $season->update($request->validated());
        return redirect()->route('accommodations.seasons.index')->with('success', 'تم تحديث الموسم بنجاح!');
    }

    public function destroy($id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->route('accommodations.seasons.index')->with('error', 'الموسم غير موجود!');
        }
        $season->delete();
        return redirect()->route('accommodations.seasons.index')->with('success', 'تم حذف الموسم بنجاح!');
    }

    public function importForm()
    {
        return view('pages.dashboard.accommodations.seasons.import');
    }
}