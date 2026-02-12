<?php

namespace Modules\Geography\Http\Controllers;

use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Language;
use Modules\Geography\Entities\CityState;
use Illuminate\Http\Request;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Geography\Http\Requests\Country\StoreRequest;
use Modules\Geography\Http\Requests\Country\UpdateRequest;

class CountryController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('geography::countries.index');
    }

    public function create()
    {
        return view('geography::countries.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $country = Country::create($validated);
        if (!$country)
            return redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_creation_failed', ['type' => __('main.country')]));
        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $country, 'photo', 'countries');
        }
        return $country
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.country')]))
                : redirect()->route('dashboard.geography.countries.index')->withSuccess(__('messages.type_created', ['type' => __('main.country')])))
            : redirect()->back()->withError(__('messages.type_creation_failed', ['type' => __('main.country')]));
    }

    public function show($id)
    {
        $country = Country::with((new Country)->getRelationshipNames())->find($id);
        if (!$country)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        return view('geography::countries.show', compact('country'));
    }

    public function edit($id)
    {
        $country = Country::find($id);
        if (!$country)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        return view('geography::countries.edit', compact('country'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $country = Country::find($id);
        if (!$country)
            return redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_update_failed', ['type' => __('main.country')]));
        $validated = $request->validated();
        if ($request->input('remove_photo') && $request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $country, 'photo', 'countries');
        }
        $updated = $country->update($validated);
        return $updated
            ? redirect()->route('dashboard.geography.countries.index')->withSuccess(__('messages.type_updated', ['type' => __('main.country')]))
            : redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_update_failed', ['type' => __('main.country')]));
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        if (!$country)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.country')]));
        $deleted = $country->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.countries.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.country')]))
            : redirect()->route('dashboard.geography.countries.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.country')]));
    }

    public function bulkEdit(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !$action) {
            return redirect()->back()->withError(__('messages.select_countries_and_action'));
        }

        switch ($action) {
            case 'delete':
                $deleted = Country::whereIn('id', $ids)->delete();
                return redirect()->back()->withSuccess(__('messages.countries_deleted', ['count' => $deleted]));
            default:
                return redirect()->back()->withError(__('messages.unknown_action'));
        }
    }
}