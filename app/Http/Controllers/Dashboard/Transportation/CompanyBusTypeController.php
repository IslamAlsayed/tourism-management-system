<?php

namespace App\Http\Controllers\Dashboard\Transportation;

use App\Http\Controllers\Controller;
use App\Models\TransportationBusType;
use App\Models\TransportationCompany;
use App\Models\TransportationCompanyBusType;
use App\Http\Requests\TransportationCompanyBusTypes\TransportationCompanyBusTypesCreateRequest;
use App\Http\Requests\TransportationCompanyBusTypes\TransportationCompanyBusTypesUpdateRequest;

class CompanyBusTypeController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportation-company-bus-types.index');
    }

    public function create()
    {
        $transportationCompanies = TransportationCompany::all();
        $transportationBusTypes = TransportationBusType::all();
        return view('pages.dashboard.transportation-company-bus-types.create', compact('transportationCompanies', 'transportationBusTypes'));
    }

    public function store(TransportationCompanyBusTypesCreateRequest $request)
    {
        $validated = $request->validated();
        $transportationCompanyBusTypes = TransportationBusType::create($validated);

        if ($transportationCompanyBusTypes) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportation_company_bus_type')]));
            }
            return redirect()->route('transportation-company-bus-types.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportation_company_bus_type')]));
        }

        return redirect()->route('transportation-company-bus-types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.restaurant')]));
    }

    public function edit($id)
    {
        $transportationCompanyBusType = TransportationCompanyBusType::find($id);
        $transportationCompanies = TransportationCompany::all();
        $transportationBusTypes = TransportationBusType::all();
        if (!$transportationCompanyBusType) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_company_bus_type')]));
        }
        return view('pages.dashboard.transportation-company-bus-types.edit', compact('transportationCompanyBusType', 'transportationCompanies', 'transportationBusTypes'));
    }

    public function update(TransportationCompanyBusTypesUpdateRequest $request, $id)
    {
        $transportationCompanyBusTypes = TransportationCompanyBusType::find($id);
        if (!$transportationCompanyBusTypes) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_company_bus_type')]));
        }

        $validated = $request->validated();
        $updated = $transportationCompanyBusTypes->update($validated);

        if ($updated) {
            return redirect()->route('transportation-company-bus-types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportation_company_bus_type')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportation_company_bus_type')]));
    }

    public function destroy($id)
    {
        $transportationCompanyBusTypes = TransportationCompanyBusType::find($id);
        if (!$transportationCompanyBusTypes) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_company_bus_type')]));
        }
        $deleted = $transportationCompanyBusTypes->delete();
        if ($deleted) {
            return redirect()->route('transportation-company-bus-types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportation_company_bus_type')]));
        }

        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.transportation_company_bus_type')]));
    }
}