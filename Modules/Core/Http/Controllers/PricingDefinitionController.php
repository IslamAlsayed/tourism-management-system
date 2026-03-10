<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Core\Entities\PricingDefinition;
use Modules\Core\Entities\PricingDefinitionModule;
use \App\Http\Requests\PricingDefinition\StoreRequest;
use \App\Http\Requests\PricingDefinition\UpdateRequest;

class PricingDefinitionController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        return view('core::pricing-definitions.index', compact('category'));
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

        // Sync module assignments
        $this->syncModuleAssignments($pricing, $request->input('modules', []));

        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.pricing-definition')]))
            : redirect()->route('dashboard.core.pricing-definitions.index')->withSuccess(__('messages.type_created', ['type' => __('main.pricing-definition')]));
    }

    public function show($id)
    {
        $pricing = PricingDefinition::with('moduleAssignments')->find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.pricing-definition')]));
        return view('core::pricing-definitions.show', compact('pricing'));
    }

    public function edit($id)
    {
        $pricing = PricingDefinition::with('moduleAssignments')->find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.pricing-definition')]));
        return view('core::pricing-definitions.edit', compact('pricing'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $pricing = PricingDefinition::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.pricing-definition')]));
        $data = $request->validated();
        $updated = $pricing->update($data);

        // Sync module assignments
        $this->syncModuleAssignments($pricing, $request->input('modules', []));

        return $updated
            ? redirect()->route('dashboard.core.pricing-definitions.index')->withSuccess(__('messages.type_updated', ['type' => __('main.pricing-definition')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.pricing-definition')]));
    }

    public function destroy($id)
    {
        $pricing = PricingDefinition::find($id);
        if (!$pricing)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.pricing-definition')]));
        $deleted = $pricing->delete();
        return $deleted
            ? redirect()->route('dashboard.core.pricing-definitions.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.pricing-definition')]))
            : redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.pricing-definition')]));
    }
    /**
     * Sync module assignments for a pricing definition.
     */
    private function syncModuleAssignments(PricingDefinition $pricing, array $modules): void
    {
        // Remove old assignments
        $pricing->moduleAssignments()->delete();

        // Create new assignments
        foreach ($modules as $moduleName => $moduleData) {
            if (!isset($moduleData['enabled'])) continue;
            $pricing->moduleAssignments()->create([
                'module_name' => $moduleName,
                'field_name' => $moduleData['field_name'] ?? null,
                'section_label' => $moduleData['section_label'] ?? null,
                'is_active' => true,
            ]);
        }
    }
}
