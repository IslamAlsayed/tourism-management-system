<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use App\Models\Region;
use App\Models\Timezone;
use App\Models\Nationality;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientCreateRequest;
use App\Http\Requests\Client\ClientUpdateRequest;

class ClientController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.clients.index');
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        $nationalities = Nationality::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.clients.create', compact('regions', 'nationalities', 'timezones'));
    }

    public function store(ClientCreateRequest $request)
    {
        $validated = $request->validated();

        // Handle state_id and city_id arrays (if multi-select)
        if (isset($validated['state_id']) && is_array($validated['state_id'])) {
            $validated['state_id'] = $validated['state_id'][0] ?? null;
        }
        if (isset($validated['city_id']) && is_array($validated['city_id'])) {
            $validated['city_id'] = $validated['city_id'][0] ?? null;
        }

        // Set created_by
        $validated['created_by'] = getActiveUser()->id;

        $created = Client::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.client')]));
            }

            return redirect()->route('clients.index')->withSuccess(__('messages.type_created', ['type' => __('main.client')]));
        }

        return redirect()->route('clients.index')->withError(__('messages.type_creation_failed', ['type' => __('main.client')]));
    }

    public function show($id)
    {
        $client = Client::with(['region', 'subregion', 'country', 'state', 'city', 'nationality', 'creator', 'updater'])->find($id);

        if (!$client) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        }

        return view('pages.dashboard.clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        }
        $regions = Region::orderBy('name')->get();
        $nationalities = Nationality::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.clients.edit', compact('client', 'regions', 'nationalities', 'timezones'));
    }

    public function update(ClientUpdateRequest $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        }

        $validated = $request->validated();

        // Handle state_id and city_id arrays (if multi-select)
        if (isset($validated['state_id']) && is_array($validated['state_id'])) {
            $validated['state_id'] = $validated['state_id'][0] ?? null;
        }
        if (isset($validated['city_id']) && is_array($validated['city_id'])) {
            $validated['city_id'] = $validated['city_id'][0] ?? null;
        }

        // Set updated_by
        $validated['updated_by'] = getActiveUser()->id;

        $updated = $client->update($validated);

        if ($updated) {
            return redirect()->route('clients.index')->withSuccess(__('messages.type_updated', ['type' => __('main.client')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.client')]));
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        }
        $deleted = $client->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.client')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.client')]));
    }
}