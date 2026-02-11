<?php

namespace Modules\TravelDocuments\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\TravelDocuments\Entities\VisaRequirement;
use Modules\TravelDocuments\Http\Requests\TravelPasse\StoreRequest;
use Modules\TravelDocuments\Http\Requests\TravelPasse\UpdateRequest;

class VisaRequirementController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('traveldocuments::visa-requirements.index');
    }

    public function create()
    {
        $visaTypes = VisaRequirement::getVisaTypes();
        $visaCategories = VisaRequirement::getVisaCategories();
        return view('traveldocuments::visa-requirements.create', compact('visaTypes', 'visaCategories'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();
        $validated['last_verified_at'] = now();
        $created = VisaRequirement::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.visa-requirement')]))
                : redirect()->route('dashboard.traveldocuments.visa-requirements.index')->withSuccess(__('messages.type_created', ['type' => __('main.visa-requirement')])))
            : redirect()->route('dashboard.traveldocuments.visa-requirements.index')->withError(__('messages.type_creation_failed', ['type' => __('main.visa-requirement')]));
    }

    public function show($id)
    {
        $visaRequirement = VisaRequirement::with((new VisaRequirement())->getRelationshipNames())->find($id);
        if (!$visaRequirement)
            return redirect()->route('dashboard.traveldocuments.visa-requirements.index')->withError(__('messages.not_found_this_type', ['type' => __('main.visa-requirement')]));
        return view('traveldocuments::visa-requirements.show', compact('visaRequirement'));
    }

    public function edit($id)
    {
        $visaRequirement = VisaRequirement::find($id);
        if (!$visaRequirement)
            return redirect()->route('dashboard.traveldocuments.visa-requirements.index')->withError(__('messages.not_found_this_type', ['type' => __('main.visa-requirement')]));
        $visaTypes = VisaRequirement::getVisaTypes();
        $visaCategories = VisaRequirement::getVisaCategories();
        return view('traveldocuments::visa-requirements.edit', compact('visaRequirement', 'visaTypes', 'visaCategories'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $visaRequirement = VisaRequirement::find($id);
        if (!$visaRequirement)
            return redirect()->route('dashboard.traveldocuments.visa-requirements.index')->withError(__('messages.not_found_this_type', ['type' => __('main.visa-requirement')]));
        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();
        $validated['last_verified_at'] = now();
        $updated = $visaRequirement->update($validated);
        return $updated
            ? redirect()->route('dashboard.traveldocuments.visa-requirements.index')->withSuccess(__('messages.type_updated', ['type' => __('main.visa-requirement')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.visa-requirement')]));
    }

    public function destroy($id)
    {
        $visaRequirement = VisaRequirement::find($id);
        if (!$visaRequirement)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.visa-requirement')]));
        $visaRequirement->media()->delete();
        $deleted = $visaRequirement->delete();
        return $deleted
            ? redirect()->route('dashboard.traveldocuments.visa-requirements.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.visa-requirement')]))
            : redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.visa-requirement')]));
    }
}
