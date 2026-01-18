<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\TouristSite;
use App\Models\TouristService;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\TouristService\StoreRequest;
use App\Http\Requests\TouristService\UpdateRequest;

class TouristServiceController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tourist-services.index');
    }

    public function create()
    {
        $sites = TouristSite::orderBy('sort_order')->get(['id', 'name']);
        return view('pages.dashboard.tourist-services.create', compact('sites'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUser()->id;
        $created = TouristService::create($validated);
        if ($created) {
            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tourist-service')]))
                : redirect()->route('tourist-services.index')->withSuccess(__('messages.type_created', ['type' => __('main.tourist-service')]));
        }
        return redirect()->route('tourist-services.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tourist-service')]));
    }

    public function show($id)
    {
        $touristService = TouristService::with((new TouristService())->getRelationshipNames())->find($id);
        if (!$touristService)
            return redirect()->route('tourist-services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        return view('pages.dashboard.tourist-services.show', compact('touristService'));
    }

    public function edit($id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->route('tourist-services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        $sites = TouristSite::orderBy('sort_order')->get(['id', 'name']);
        return view('pages.dashboard.tourist-services.edit', compact('touristService', 'sites'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->route('tourist-services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        $validated = $request->validated();
        $validated['updated_by'] = getActiveUser()->id;
        $updated = $touristService->update($validated);
        return $updated
            ? redirect()->route('tourist-services.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tourist-service')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tourist-service')]));
    }

    public function destroy($id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        $deleted = $touristService->delete();
        return $deleted
            ? redirect()->route('tourist-services.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tourist-service')]))
            : redirect()->route('tourist-services.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tourist-service')]));
    }
}