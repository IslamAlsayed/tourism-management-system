<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Airline;
use App\Http\Controllers\Controller;
use App\Http\Requests\Airline\StoreRequest;
use App\Http\Requests\Airline\UpdateRequest;

class AirlineController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.airlines.index');
    }

    public function create()
    {
        return view('pages.dashboard.airlines.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        Airline::create($validated);
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.airline')]))
            : redirect()->route('airlines.index')->withSuccess(__('messages.type_created', ['type' => __('main.airline')]));
    }

    public function show($id)
    {
        $airline = Airline::with((new Airline)->getRelationshipNames())->find($id);
        if (!$airline)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airline')]));
        return view('pages.dashboard.airlines.show', compact('airline'));
    }

    public function edit($id)
    {
        $airline = Airline::find($id);
        if (!$airline)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airline')]));
        return view('pages.dashboard.airlines.edit', compact('airline'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $airline = Airline::find($id);
        if (!$airline)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airline')]));
        $validated = $request->validated();
        $updated = $airline->update($validated);
        return $updated
            ? redirect()->route('airlines.index')->withSuccess(__('messages.type_updated', ['type' => __('main.airline')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.airline')]));
    }

    public function destroy($id)
    {
        $airline = Airline::find($id);
        if (!$airline)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.airline')]));
        $deleted = $airline->delete();
        return $deleted
            ? redirect()->route('airlines.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.airline')]))
            : redirect()->route('airlines.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.airline')]));
    }
}