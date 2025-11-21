<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Region;
use App\Models\Airline;
use App\Models\Timezone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Airline\AirlineCreateRequest;
use App\Http\Requests\Airline\AirlineUpdateRequest;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.dashboard.airlines.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.airlines.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AirlineCreateRequest $request)
    {
        try {
            $data = $request->validated();
            $airline = Airline::create($data);
            return redirect()->route('airlines.index')->withSuccess(__('main.airline_created_successfully'));
        } catch (\Exception $e) {
            return back()->withError(__('main.error_occurred'))->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Airline $airline)
    {
        $airline->load(['region', 'subregion', 'country', 'state', 'city']);
        return view('pages.dashboard.airlines.show', compact('airline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $airline = Airline::find($id);
        if (!$airline) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.airline')]));
        }
        $regions = Region::orderBy('name')->get();
        $timezones = Timezone::orderBy('name')->get(['name', 'name_ar', 'abbreviation', 'id'])->toArray();
        return view('pages.dashboard.airlines.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AirlineUpdateRequest $request, Airline $airline)
    {
        try {
            $data = $request->validated();
            $airline->update($data);
            return redirect()->route('airlines.index')->withSuccess(__('main.airline_updated_successfully'));
        } catch (\Exception $e) {
            return back()->withError(__('main.error_occurred'))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $airline = Airline::find($id);
        if (!$airline) {
            return redirect()->back()->withError(__('main.messages.not_found_this_type', ['type' => __('main.airline')]));
        }
        $deleted = $airline->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('main.messages.type_deleted', ['type' => __('main.airline')]));
        }
        return redirect()->back()->withError(__('main.messages.type_deletion_failed', ['type' => __('main.airline')]));
    }
}