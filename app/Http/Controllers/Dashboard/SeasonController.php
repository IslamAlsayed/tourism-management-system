<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Season;
use App\Http\Controllers\Controller;
use App\Http\Requests\Season\StoreRequest;
use App\Http\Requests\Season\UpdateRequest;

class SeasonController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.seasons.index');
    }

    public function create()
    {
        return view('pages.dashboard.seasons.create');
    }

    public function store(StoreRequest $request)
    {
        Season::create($request->validated());
        return redirect()->route('seasons.index')->with('success', 'تم إنشاء الموسم بنجاح!');
    }

    public function edit($id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->route('seasons.index')->with('error', 'الموسم غير موجود!');
        }
        return view('pages.dashboard.seasons.edit', compact('season'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->route('seasons.index')->with('error', 'الموسم غير موجود!');
        }
        $season->update($request->validated());
        return redirect()->route('seasons.index')->with('success', 'تم تحديث الموسم بنجاح!');
    }

    public function destroy($id)
    {
        $season = Season::find($id);
        if (!$season) {
            return redirect()->route('seasons.index')->with('error', 'الموسم غير موجود!');
        }
        $season->delete();
        return redirect()->route('seasons.index')->with('success', 'تم حذف الموسم بنجاح!');
    }

    public function importForm()
    {
        return view('pages.dashboard.seasons.import');
    }
}