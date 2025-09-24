<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use App\Models\Nationality;
use App\Http\Controllers\Controller;
use App\Http\Requests\Nationalities\NationalitiesCreateRequest;
use App\Http\Requests\Nationalities\NationalitiesUpdateRequest;

class NationalityController extends Controller
{
    public function index()
    {
        $nationalities = Nationality::paginate(getPaginate());
        $total = Nationality::count();
        return view('pages.dashboard.nationalities.index', compact('nationalities', 'total'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('pages.dashboard.nationalities.create', compact('countries'));
    }

    public function store(NationalitiesCreateRequest $request)
    {
        $validated = $request->validated();
        $created = Nationality::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->route('nationalities.create')->with('success', __('main.messages.type_created', ['type' => __('main.nationality')]));
            }
            return redirect()->route('nationalities.index')->with('success', __('main.messages.type_created', ['type' => __('main.nationality')]));
        }

        return redirect()->route('nationalities.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.nationality')]));
    }

    public function edit($id)
    {
        $nationality = Nationality::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        return view('pages.dashboard.nationalities.edit', compact('nationality', 'countries'));
    }

    public function update(NationalitiesUpdateRequest $request, $id)
    {
        $nationality = Nationality::findOrFail($id);
        $validated = $request->validated();

        $updated = $nationality->update($validated);
        if ($updated) {
            return redirect()->route('nationalities.index')->with('success', __('main.messages.type_updated', ['type' => __('main.nationality')]));
        }

        return redirect()->route('nationalities.index')->with('error', __('main.messages.type_update_failed', ['type' => __('main.nationality')]));
    }

    public function destroy($id)
    {
        $nationality = Nationality::findOrFail($id);
        $deleted = $nationality->delete();
        if ($deleted) {
            return redirect()->route('nationalities.index')->with('success', __('main.messages.type_deleted', ['type' => __('main.nationality')]));
        }

        return redirect()->route('nationalities.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.nationality')]));
    }
}