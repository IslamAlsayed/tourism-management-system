<?php

namespace Modules\CRM\Http\Controllers;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\CRM\Entities\Client;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Nationality;

class ClientController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('crm::clients.index');
    }

    public function create()
    {
        $nationalities = Nationality::orderBy('name')->get();
        $citiesCount = City::count();
        return view('crm::clients.create', compact('nationalities', 'citiesCount'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = getActiveUserId();
        $client = Client::create($data);
        if (!$client)
            return redirect()->route('dashboard.crm.clients.index')->withError(__('messages.type_creation_failed', ['type' => __('main.client')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.client')]))
            : redirect()->route('dashboard.crm.clients.index')->withSuccess(__('messages.type_created', ['type' => __('main.client')]));
    }

    public function show($id)
    {
        $client = Client::with((new Client)->getRelationshipNames())->find($id);
        return $client
            ? view('crm::clients.show', compact('client'))
            : redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
    }

    public function edit($id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        $nationalities = Nationality::orderBy('name')->get();
        $citiesCount = City::count();
        return view('crm::clients.edit', compact('client', 'nationalities', 'citiesCount'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        $data = $request->validated();
        $data['updated_by'] = getActiveUserId();
        $updated = $client->update($data);
        return $updated
            ? redirect()->route('dashboard.crm.clients.index')->withSuccess(__('messages.type_updated', ['type' => __('main.client')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.client')]));
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.client')]));
        $deleted = $client->delete();
        return $deleted
            ? redirect()->route('dashboard.crm.clients.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.client')]))
            : redirect()->route('dashboard.crm.clients.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.client')]));
    }
}
