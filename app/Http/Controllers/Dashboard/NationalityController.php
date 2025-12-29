<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\Timezone;
use App\Models\Nationality;
use App\Http\Controllers\Controller;
use App\Http\Requests\Nationality\StoreRequest;
use App\Http\Requests\Nationality\UpdateRequest;

class NationalityController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.nationalities.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.nationalities.create', compact('regions', 'timezones'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $nationality = Nationality::create($data);
        if (!$nationality)
            return redirect()->route('nationalities.index')->withError(__('messages.type_creation_failed', ['type' => __('main.nationality')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.nationality')]))
            : redirect()->route('nationalities.index')->withSuccess(__('messages.type_created', ['type' => __('main.nationality')]));
    }

    public function show($id)
    {
        $nationality = Nationality::with(['region', 'subregion', 'country', 'state', 'city'])->find($id);
        return $nationality
            ? view('pages.dashboard.nationalities.show', compact('nationality'))
            : redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.nationality')]));
    }

    public function edit($id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.nationalities.edit', compact('nationality', 'regions', 'timezones'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        $data = $request->validated();
        $updated = $nationality->update($data);
        return $updated
            ? redirect()->route('nationalities.index')->withSuccess(__('messages.type_updated', ['type' => __('main.nationality')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.nationality')]));
    }

    public function destroy($id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        $deleted = $nationality->delete();
        return $deleted
            ? redirect()->route('nationalities.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.nationality')]))
            : redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.nationality')]));
    }
}