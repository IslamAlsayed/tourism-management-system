<?php

namespace App\Http\Controllers\Dashboard\Transportations;

use App\Models\Season;
use App\Models\Supplement;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;
use App\Http\Requests\Transportation\Company\StoreRequest;
use App\Http\Requests\Transportation\Company\UpdateRequest;
use App\Models\TransportationVehicleType;

class CompanyController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.transportations.companies.index');
    }

    public function create()
    {
        return view('pages.dashboard.transportations.companies.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        // Create transportation company (basic fields only)
        $company = TransportationCompany::create($request->except(['vehicle_types', 'seasons', 'supplements']));

        // VEHICLE TYPES
        if (!empty($validated['vehicle_types'])) {
            foreach ($validated['vehicle_types'] as $vehicleTypeData) {
                TransportationVehicleType::create(attributes: $vehicleTypeData);
            }
        }

        // SEASONS
        if (!empty($validated['seasons'])) {
            foreach ($validated['seasons'] as $seasonData) {
                $seasonData['model_id'] = $company->id;
                $seasonData['model_type'] = TransportationCompany::class;
                Season::create($seasonData);
            }
        }

        // SUPPLEMENTS
        if (!empty($validated['supplements'])) {
            foreach ($validated['supplements'] as $supplementData) {
                $supplementData['model_id'] = $company->id;
                $supplementData['model_type'] = TransportationCompany::class;
                Supplement::create($supplementData);
            }
        }

        $validated = array_merge($validated, $request->safe()->except('photo'));
        if (!$company)
            return redirect()->route('transportations.companies.index')->withError(__('messages.type_creation_failed', ['type' => __('main.company')]));
        $this->uploadPhoto($request, $company, 'photo', "transportation/companies");
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.company')]))
            : redirect()->route('transportations.companies.index')->withSuccess(__('messages.type_created', ['type' => __('main.company')]));
    }

    public function show($id)
    {
        $company = TransportationCompany::with((new TransportationCompany())->getRelationshipNames())->find($id);
        if (!$company)
            return redirect()->route('transportations.companies.index')->withError(__('messages.type_not_found', ['type' => __('main.transportations-company')]));
        return view('pages.dashboard.transportations.companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = TransportationCompany::with((new TransportationCompany())->getRelationshipNames())->find($id);
        if (!$company)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-company')]));
        return view('pages.dashboard.transportations.companies.edit', compact('company'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $company = TransportationCompany::find($id);
        if (!$company)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-company')]));
        $validated = $request->validated();
        $validated = array_merge($validated, $request->safe()->except('photo'));
        $updated = $company->update($validated);

        if ($request->has('photo')) {
            $this->uploadPhoto($request, $company, 'photo', "transportation/companies");
        }

        // VEHICLE TYPES
        if (!empty($validated['vehicle_types'])) {
            $company->vehicleTypes()->delete();
            foreach ($validated['vehicle_types'] as $vehicleTypeData) {
                TransportationVehicleType::create(attributes: $vehicleTypeData);
            }
        }

        // EDIT SEASONS
        if (!empty($validated['seasons'])) {
            $company->seasons()->where('model_type', TransportationCompany::class)->where('model_id', $company->id)->delete();
            foreach ($validated['seasons'] as $seasonData) {
                $seasonData['model_id'] = $company->id;
                $seasonData['model_type'] = TransportationCompany::class;
                Season::create($seasonData);
            }
        }

        // EDIT SUPPLEMENTS
        if (!empty($validated['supplements'])) {
            $company->supplements()->where('model_type', TransportationCompany::class)->where('model_id', $company->id)->delete();
            foreach ($validated['supplements'] as $supplementData) {
                $supplementData['model_id'] = $company->id;
                $supplementData['model_type'] = TransportationCompany::class;
                Supplement::create($supplementData);
            }
        }

        return $updated
            ? redirect()->route('transportations.companies.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportations-company')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportations-company')]));
    }

    public function destroy($id)
    {
        $company = TransportationCompany::find($id);
        if (!$company)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportations-company')]));
        $deleted = $company->delete();
        return $deleted
            ? redirect()->route('transportations.companies.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportations-company')]))
            : redirect()->route('transportations.companies.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportations-company')]));
    }
}