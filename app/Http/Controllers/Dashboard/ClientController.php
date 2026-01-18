<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use App\Models\Nationality;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;

class ClientController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.clients.index');
    }

    public function create()
    {
        $nationalities = Nationality::orderBy('name')->get();
        return view('pages.dashboard.clients.create', compact('nationalities'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = getActiveUser()->id;
        $client = Client::create($data);
        if (!$client)
            return redirect()->route('clients.index')->withError(__('messages.type_creation_failed', ['type' => __('main.client')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.client')]))
            : redirect()->route('clients.index')->withSuccess(__('messages.type_created', ['type' => __('main.client')]));
    }

    public function show($id)
    {
        $client = Client::with((new Client)->getRelationshipNames())->find($id);
        return $client
            ? view('pages.dashboard.clients.show', compact('client'))
            : redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
    }

    public function edit($id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        $nationalities = Nationality::orderBy('name')->get();
        return view('pages.dashboard.clients.edit', compact('client', 'nationalities'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        $data = $request->validated();
        $data['updated_by'] = getActiveUser()->id;
        $updated = $client->update($data);
        return $updated
            ? redirect()->route('clients.index')->withSuccess(__('messages.type_updated', ['type' => __('main.client')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.client')]));
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        $deleted = $client->delete();
        return $deleted
            ? redirect()->route('clients.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.client')]))
            : redirect()->route('clients.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.client')]));
    }
}