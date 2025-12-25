<?php

namespace App\Http\Controllers\Dashboard\Transportation;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Subregion;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;
use App\Models\TransportationCompanyDepartment;
use App\Http\Requests\TransportationDepartments\TransportationDepartmentsCreateRequest;
use App\Http\Requests\TransportationDepartments\TransportationDepartmentsUpdateRequest;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportation-departments.index');
    }

    public function create()
    {
        $transportationCompanies = TransportationCompany::all();
        $countries = Country::all();
        $states = State::limit(15)->get();
        $cities = City::limit(15)->get();
        $regions = Region::all();
        $subregions = Subregion::all();

        return view('pages.dashboard.transportation-departments.create', compact('transportationCompanies', 'countries', 'states', 'cities', 'regions', 'subregions'));
    }

    public function store(TransportationDepartmentsCreateRequest $request)
    {
        $validated = $request->validated();
        $transportationDepartment = TransportationCompanyDepartment::create($validated);

        if ($transportationDepartment) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportation_department')]));
            }
            return redirect()->route('transportation-departments.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportation_department')]));
        }

        return redirect()->route('transportation-departments.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
    }

    public function edit($id)
    {
        $transportationDepartment = TransportationCompanyDepartment::find($id);
        $transportationCompanies = TransportationCompany::all();
        $countries = Country::all();
        $states = State::limit(15)->get();
        $cities = City::limit(15)->get();
        $regions = Region::all();
        $subregions = Subregion::all();

        if (!$transportationDepartment) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_department')]));
        }
        return view('pages.dashboard.transportation-departments.edit', compact('transportationDepartment', 'transportationCompanies', 'countries', 'states', 'cities', 'regions', 'subregions'));
    }

    public function update(TransportationDepartmentsUpdateRequest $request, $id)
    {
        $transportationDepartment = TransportationCompanyDepartment::find($id);
        if (!$transportationDepartment) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_department')]));
        }

        $validated = $request->validated();
        $updated = $transportationDepartment->update($validated);

        if ($updated) {
            return redirect()->route('transportation-departments.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportation_department')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportation_department')]));
    }

    public function destroy($id)
    {
        $transportationDepartment = TransportationCompanyDepartment::find($id);
        if (!$transportationDepartment) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_department')]));
        }
        $deleted = $transportationDepartment->delete();
        if ($deleted) {
            return redirect()->route('transportation-departments.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportation_department')]));
        }

        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.transportation_department')]));
    }
}