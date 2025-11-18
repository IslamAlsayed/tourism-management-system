<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\TouristSite;
use App\Models\Region;
use App\Models\Currency;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\TouristSite\TouristSiteCreateRequest;
use App\Http\Requests\TouristSite\TouristSiteUpdateRequest;

class TouristSiteController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tourist-sites.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        $siteTypes = config('helpers.site_types') ?: [];
        $categories = config('helpers.categories') ?: [];
        $difficultyLevels = TouristSite::getDifficultyLevels();
        $statuses = TouristSite::getStatuses();
        return view('pages.dashboard.tourist-sites.create', get_defined_vars());
    }

    public function store(TouristSiteCreateRequest $request)
    {
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except('photo'));

        // Handle location arrays (if multi-select)
        if (isset($data['state_id']) && is_array($data['state_id'])) {
            $data['state_id'] = $data['state_id'][0] ?? null;
        }
        if (isset($data['city_id']) && is_array($data['city_id'])) {
            $data['city_id'] = $data['city_id'][0] ?? null;
        }

        // Handle JSON fields
        $jsonFields = ['facilities', 'activities', 'services', 'operating_days', 'tags', 'best_visit_time'];
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = json_decode($data[$field], true);
            }
        }

        // Set created_by
        $data['created_by'] = getActiveUser()->id;
        $created = TouristSite::create($data);
        if ($created) {
            $this->uploadPhoto($request, $created, 'photo', "tourist-sites");
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('main.messages.type_created', ['type' => __('main.tourist_site')]));
            }

            return redirect()->route('tourist-sites.index')->withSuccess(__('main.messages.type_created', ['type' => __('main.tourist_site')]));
        }

        return redirect()->route('tourist-sites.index')->withError(__('main.messages.type_creation_failed', ['type' => __('main.tourist_site')]));
    }

    public function show($id)
    {
        $touristSite = TouristSite::with(['region', 'subregion', 'country', 'state', 'city', 'creator', 'updater'])->find($id);
        if (!$touristSite) {
            return redirect()->route('tourist-sites.index')->withError(__('main.messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        }
        return view('pages.dashboard.tourist-sites.show', compact('touristSite'));
    }

    public function edit($id)
    {
        $touristSite = TouristSite::with(['region', 'subregion', 'country', 'state', 'city'])->find($id);
        if (!$touristSite) {
            return redirect()->route('tourist-sites.index')->withError(__('main.messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        }
        $regions = Region::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        $siteTypes = config('helpers.site_types') ?: [];
        $categories = config('helpers.categories') ?: [];
        $difficultyLevels = TouristSite::getDifficultyLevels();
        $statuses = TouristSite::getStatuses();
        return view('pages.dashboard.tourist-sites.edit', get_defined_vars());
    }

    public function update(TouristSiteUpdateRequest $request, $id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite) {
            return redirect()->route('tourist-sites.index')->withError(__('main.messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        }
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except('photo'));
        // Handle location arrays (if multi-select)
        if (isset($data['state_id']) && is_array($data['state_id'])) {
            $data['state_id'] = $data['state_id'][0] ?? null;
        }
        if (isset($data['city_id']) && is_array($data['city_id'])) {
            $data['city_id'] = $data['city_id'][0] ?? null;
        }
        // Handle JSON fields
        $jsonFields = ['facilities', 'activities', 'services', 'operating_days', 'tags', 'best_visit_time'];
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = json_decode($data[$field], true);
            }
        }
        // Set updated_by
        $data['updated_by'] = getActiveUser()->id;
        $updated = $touristSite->update($data);
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $touristSite, 'photo', "tourist-sites");
        }
        if ($updated) {
            return redirect()->route('tourist-sites.index')->withSuccess(__('main.messages.type_updated', ['type' => __('main.tourist_site')]));
        }
        return redirect()->route('tourist-sites.index')->withError(__('main.messages.type_update_failed', ['type' => __('main.tourist_site')]));
    }

    public function destroy($id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        }
        $deleted = $touristSite->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.tourist_site')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.tourist_site')]));
    }
}