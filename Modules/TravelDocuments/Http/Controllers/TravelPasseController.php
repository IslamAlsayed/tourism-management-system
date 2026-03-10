<?php

namespace Modules\TravelDocuments\Http\Controllers;

use Modules\TouristSites\Entities\TouristSite;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\TravelDocuments\Entities\TravelPasse;
use Modules\TravelDocuments\Http\Requests\TravelPass\StoreRequest;
use Modules\TravelDocuments\Http\Requests\TravelPass\UpdateRequest;

class TravelPasseController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('traveldocuments::travel-passes.index');
    }

    public function create()
    {
        $touristSites = TouristSite::orderBy('name')->get();
        $passTypes = TravelPasse::getPassTypes();
        return view('traveldocuments::travel-passes.create', compact('touristSites', 'passTypes'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();
        $created = TravelPasse::create($validated);

        if ($created) {
            if ($request->has('sites'))
                $created->touristSites()->sync($request->sites);

            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.travel-pass')]))
                : redirect()->route('dashboard.traveldocuments.travel-passes.index')->withSuccess(__('messages.type_created', ['type' => __('main.travel-pass')]));
        }
        return redirect()->route('dashboard.traveldocuments.travel-passes.index')->withError(__('messages.type_creation_failed', ['type' => __('main.travel-pass')]));
    }

    public function show($id)
    {
        $travelPass = TravelPasse::with((new TravelPasse())->getRelationshipNames())->find($id);
        if (!$travelPass)
            return redirect()->route('dashboard.traveldocuments.travel-passes.index')->withError(__('messages.not_found_this_type', ['type' => __('main.travel-pass')]));
        return view('traveldocuments::travel-passes.show', compact('travelPass'));
    }

    public function edit($id)
    {
        $travelPass = TravelPasse::with('touristSites:id')->find($id);
        if (!$travelPass)
            return redirect()->route('dashboard.traveldocuments.travel-passes.index')->withError(__('messages.not_found_this_type', ['type' => __('main.travel-pass')]));
        $touristSites = TouristSite::orderBy('name')->get();
        $passTypes = TravelPasse::getPassTypes();
        return view('traveldocuments::travel-passes.edit', compact('travelPass', 'touristSites', 'passTypes'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $travelPass = TravelPasse::find($id);
        if (!$travelPass)
            return redirect()->route('dashboard.traveldocuments.travel-passes.index')->withError(__('messages.not_found_this_type', ['type' => __('main.travel-pass')]));

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();
        $updated = $travelPass->update($validated);

        if ($request->has('sites')) {
            $travelPass->touristSites()->sync($request->sites);
        } else {
            $travelPass->touristSites()->detach();
        }

        return $updated
            ? redirect()->route('dashboard.traveldocuments.travel-passes.index')->withSuccess(__('messages.type_updated', ['type' => __('main.travel-pass')]))
            : redirect()->route('dashboard.traveldocuments.travel-passes.index')->withError(__('messages.type_update_failed', ['type' => __('main.travel-pass')]));
    }

    public function destroy($id)
    {
        $travelPass = TravelPasse::find($id);
        if (!$travelPass)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.travel-pass')]));
        $travelPass->touristSites()->detach();
        $deleted = $travelPass->delete();
        return $deleted
            ? redirect()->route('dashboard.traveldocuments.travel-passes.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.travel-pass')]))
            : redirect()->route('dashboard.traveldocuments.travel-passes.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.travel-pass')]));
    }
}
