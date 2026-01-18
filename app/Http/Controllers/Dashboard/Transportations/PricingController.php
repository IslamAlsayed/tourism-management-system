<?php

namespace App\Http\Controllers\Dashboard\Transportations;

use App\Models\PricingDefinition;
use App\Http\Controllers\Controller;
use App\Models\TransportationPricing;
use App\Http\Requests\Transportation\Pricing\StoreRequest;
use App\Http\Requests\Transportation\Pricing\UpdateRequest;

class PricingController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.transportations.pricings.index');
    }

    public function create()
    {
        $pricingUnits = PricingDefinition::orderBy('name')->get();
        return view('pages.dashboard.transportations.pricings.create', compact('pricingUnits'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $pricing = TransportationPricing::create($data);
        if (!$pricing)
            return redirect()->route('transportations.pricings.index')->withError(__('messages.type_creation_failed', ['type' => __('main.transportation-pricing')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.transportation-pricing')]))
            : redirect()->route('transportations.pricings.index')->withSuccess(__('messages.type_created', ['type' => __('main.transportation-pricing')]));
    }

    public function show($id)
    {
        $pricing = TransportationPricing::with((new TransportationPricing())->getRelationshipNames())->find($id);
        if (!$pricing)
            return redirect()->route('transportations.pricings.index')->withError(__('messages.type_not_found', ['type' => __('main.transportation-pricing')]));
        return view('pages.dashboard.transportations.pricings.show', compact('pricing'));
    }

    public function edit($id)
    {
        $pricing = TransportationPricing::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-pricing')]));
        $pricingUnits = PricingDefinition::orderBy('name')->get();
        return view('pages.dashboard.transportations.pricings.edit', compact('pricingUnits', 'pricing'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $pricing = TransportationPricing::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-pricing')]));
        $data = $request->validated();
        $updated = $pricing->update($data);
        return $updated
            ? redirect()->route('transportations.pricings.index')->withSuccess(__('messages.type_updated', ['type' => __('main.transportation-pricing')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.transportation-pricing')]));
    }

    public function destroy($id)
    {
        $pricing = TransportationPricing::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.transportation-pricing')]));
        $deleted = $pricing->delete();
        return $deleted
            ? redirect()->route('transportations.pricings.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.transportation-pricing')]))
            : redirect()->route('transportations.pricings.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.transportation-pricing')]));
    }
}