<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Core\Entities\PricingDefinition;
use Modules\Core\Http\Requests\PricingDefinition\StoreRequest;
use Modules\Core\Http\Requests\PricingDefinition\UpdateRequest;

class PricingDefinitionController extends Controller
{
    public function index()
    {
        return view('core::pricing-definitions.index');
    }

    public function create()
    {
        return view('core::pricing-definitions.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $pricing = PricingDefinition::create($data);
        if (!$pricing)
            return redirect()->route('dashboard.core.pricing-definitions.index')->withError(__('messages.type_creation_failed', ['type' => __('main.pricing-definition')]));
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.pricing-definition')]))
            : redirect()->route('dashboard.core.pricing-definitions.index')->withSuccess(__('messages.type_created', ['type' => __('main.pricing-definition')]));
    }

    public function show($id)
    {
        $pricing = PricingDefinition::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.pricing-definition')]));
        dd($pricing->toArray());
        return view('core::pricing-definitions.show', compact('pricing'));
    }

    public function edit($id)
    {
        $pricing = PricingDefinition::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.pricing-definition')]));
        return view('core::pricing-definitions.edit', compact('pricing'));
    }

    public function update(UpdateRequest $request, $id)
    {
        dd($request->all(), $request->validated());
        $pricing = PricingDefinition::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.pricing-definition')]));
        $data = $request->validated();
        $updated = $pricing->update($data);
        return $updated
            ? redirect()->route('dashboard.core.pricing-definitions.index')->withSuccess(__('messages.type_updated', ['type' => __('main.pricing-definition')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.pricing-definition')]));
    }

    public function destroy($id) {}
}
