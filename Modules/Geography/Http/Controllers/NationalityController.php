<?php

namespace Modules\Geography\Http\Controllers;

use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\Nationality;
use Illuminate\Routing\Controller;
use Modules\Geography\Http\Requests\Nationality\StoreRequest;
use Modules\Geography\Http\Requests\Nationality\UpdateRequest;

class NationalityController extends Controller
{
    public function index()
    {
        return view('geography::nationalities.index');
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('geography::nationalities.create', compact('countries'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $nationality = Nationality::create($data);
        if (!$nationality)
            return redirect()->route('dashboard.geography.nationalities.index')->withError(__('messages.type_creation_failed', ['type' => __('main.nationality')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.nationality')]))
            : redirect()->route('dashboard.geography.nationalities.index')->withSuccess(__('messages.type_created', ['type' => __('main.nationality')]));
    }

    public function show($id)
    {
        $nationality = Nationality::with((new Nationality)->getRelationshipNames())->find($id);
        return $nationality
            ? view('geography::nationalities.show', compact('nationality'))
            : redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
    }

    public function edit($id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        $countries = Country::orderBy('name')->get();
        return view('geography::nationalities.edit', compact('nationality', 'countries'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        $data = $request->validated();
        $updated = $nationality->update($data);
        return $updated
            ? redirect()->route('dashboard.geography.nationalities.index')->withSuccess(__('messages.type_updated', ['type' => __('main.nationality')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.nationality')]));
    }

    public function destroy($id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.nationality')]));
        $deleted = $nationality->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.nationalities.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.nationality')]))
            : redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.nationality')]));
    }
}
