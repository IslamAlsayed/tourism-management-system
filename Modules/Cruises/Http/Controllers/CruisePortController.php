<?php

namespace Modules\Cruises\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Cruises\Entities\CruisePort;
use Illuminate\Http\Request;
use Modules\Cruises\Http\Requests\StoreCruisePortRequest;
use Modules\Cruises\Http\Requests\UpdateCruisePortRequest;
use Modules\Geography\Entities\Country;

class CruisePortController extends Controller
{
    public function index()
    {
        return view('cruises::ports.index');
    }

    public function create()
    {
        $countries = Country::all();
        return view('cruises::ports.create', compact('countries'));
    }

    public function store(StoreCruisePortRequest $request)
    {
        $validated = $request->validated();
        
        $validated['company_id'] = auth()->id() ?? 1;

        CruisePort::create($validated);

        return redirect()->route('dashboard.cruises.ports.index')
            ->with('success', __('main.created_successfully'));
    }

    public function edit(CruisePort $port)
    {
        $countries = Country::all();
        return view('cruises::ports.edit', compact('port', 'countries'));
    }

    public function update(UpdateCruisePortRequest $request, CruisePort $port)
    {
        $validated = $request->validated();

        $port->update($validated);

        return redirect()->route('dashboard.cruises.ports.index')
            ->with('success', __('main.updated_successfully'));
    }
}
