<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Nationality;
use App\Http\Controllers\Controller;
use App\Http\Requests\Nationalities\NationalitiesCreateRequest;
use App\Http\Requests\Nationalities\NationalitiesUpdateRequest;
use App\Models\Region;

class NationalityController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.nationalities.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.nationalities.create', compact('regions'));
    }

    public function store(NationalitiesCreateRequest $request)
    {
        $validated = $request->validated();
        $created = Nationality::create($validated);
        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.nationality')]));
            }
            return redirect()->route('nationalities.index')->withSuccess(__('messages.type_created', ['type' => __('main.nationality')]));
        }
        return redirect()->route('nationalities.index')->withError(__('messages.type_creation_failed', ['type' => __('main.nationality')]));
    }

    public function edit($id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        }
        $regions = Region::orderBy('name')->get();
        return view('pages.dashboard.nationalities.edit', compact('nationality', 'regions'));
    }

    public function update(NationalitiesUpdateRequest $request, $id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        }
        $validated = $request->validated();
        $updated = $nationality->update($validated);
        if ($updated) {
            return redirect()->route('nationalities.index')->withSuccess(__('messages.type_updated', ['type' => __('main.nationality')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.nationality')]));
    }

    public function destroy($id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        }
        $deleted = $nationality->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.nationality')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.nationality')]));
    }
}