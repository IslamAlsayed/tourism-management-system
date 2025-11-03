<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use App\Models\Nationality;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientCreateRequest;
use App\Http\Requests\Client\ClientUpdateRequest;

class ClientController extends Controller
{
    use PhotoUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.dashboard.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nationalities = Nationality::all();
        return view('pages.dashboard.clients.create', compact('nationalities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientCreateRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->except('photo');

        // Generate client code if not provided
        if (empty($validated['client_code'])) {
            $validated['client_code'] = 'CL-' . str_pad(Client::count() + 1, 6, '0', STR_PAD_LEFT);
        }

        // Build full name
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        // Set created_by
        $validated['created_by'] = getActiveUser()->id;

        $created = Client::create($validated);

        if ($created) {
            $this->uploadPhoto($request, $created, 'photo', "clients");

            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('main.messages.type_created', ['type' => __('main.client')]));
            }

            return redirect()->route('clients.index')->withSuccess(__('main.messages.type_created', ['type' => __('main.client')]));
        }

        return redirect()->route('clients.index')->withError(__('main.messages.type_creation_failed', ['type' => __('main.client')]));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::with(['nationality', 'creator', 'updater'])->find($id);

        if (!$client) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.client')]));
        }

        return view('pages.dashboard.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.client')]));
        }

        $nationalities = Nationality::all();
        return view('pages.dashboard.clients.edit', compact('client', 'nationalities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.client')]));
        }

        $validated = $request->validated();
        $validated = $request->safe()->except('photo');

        // Update full name if first or last name changed
        if (isset($validated['first_name']) || isset($validated['last_name'])) {
            $validated['name'] = ($validated['first_name'] ?? $client->first_name) . ' ' . ($validated['last_name'] ?? $client->last_name);
        }

        $this->uploadPhoto($request, $client, 'photo', "clients");

        $updated = $client->update($validated);

        if ($updated) {
            return redirect()->route('clients.index')->withSuccess(__('main.messages.type_updated', ['type' => __('main.client')]));
        }

        return redirect()->back()->withError(__('main.messages.type_update_failed', ['type' => __('main.client')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.client')]));
        }

        $deleted = $client->delete();

        if ($deleted) {
            $this->deletePhoto($client, 'photo');
            return redirect()->back()->withSuccess(__('main.messages.type_deleted', ['type' => __('main.client')]));
        }

        return redirect()->back()->withError(__('main.messages.type_deletion_failed', ['type' => __('main.client')]));
    }
}