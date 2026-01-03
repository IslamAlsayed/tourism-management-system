<?php

namespace App\Http\Controllers\Dashboard\Transportation;

use App\Models\Currency;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;
use App\Http\Requests\Transportation\Company\StoreRequest;
use App\Http\Requests\Transportation\Company\UpdateRequest;

class CompanyController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.transportation.companies.index');
    }

    public function create()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.transportation.companies.create', compact('currencies'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $created = TransportationCompany::create($data);
        if (!$created)
            return redirect()->route('transportation.companies.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportation_company')]));
        $this->uploadPhoto($request, $created, 'photo', "transportation/companies");
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportation_company')]))
            : redirect()->route('transportation.companies.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportation_company')]));
    }

    public function show($id)
    {
        $company = TransportationCompany::with((new TransportationCompany())->getRelationshipNames())->find($id);
        if (!$company)
            return redirect()->route('transportation.companies.index')->withError(__('messages.type_not_found', ['type' => __('main.transportation_company')]));
        return view('pages.dashboard.transportation.companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = TransportationCompany::find($id);
        if (!$company)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_company')]));
        $currencies = Currency::orderBy('code')->get();
        return view('pages.dashboard.transportation.companies.edit', compact('company', 'currencies'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $company = TransportationCompany::find($id);
        if (!$company)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_company')]));
        $data = $request->validated();
        $data = array_merge($data, $request->safe()->except('photo'));
        $updated = $company->update($data);
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $company, 'photo', "transportation/companies");
        }
        return $updated
            ? redirect()->route('transportation.companies.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportation_company')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportation_company')]));
    }

    public function destroy($id)
    {
        $company = TransportationCompany::find($id);
        if (!$company)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation_company')]));
        $deleted = $company->delete();
        return $deleted
            ? redirect()->route('transportation.companies.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportation_company')]))
            : redirect()->route('transportation.companies.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportation_company')]));
    }
}