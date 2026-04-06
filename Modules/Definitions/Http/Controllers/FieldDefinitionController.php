<?php

namespace Modules\Definitions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Definitions\Entities\FieldDefinition;

class FieldDefinitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('definitions::field-definitions.index');
    }

    public function create()
    {
        $modules = FieldDefinition::getModuleRegistry();
        $fieldTypes = FieldDefinition::getFieldTypes();
        return view('definitions::field-definitions.create', compact('modules', 'fieldTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'module_name' => 'required|string',
            'entity_type' => 'required|string',
            'field_type' => 'required|string|in:' . implode(',', array_keys(FieldDefinition::getFieldTypes())),
            'options' => 'nullable|string',
            'placeholder' => 'nullable|string|max:255',
            'placeholder_ar' => 'nullable|string|max:255',
            'section_label' => 'nullable|string|max:255',
            'section_label_ar' => 'nullable|string|max:255',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Parse options if present
        if (!empty($validated['options'])) {
            $validated['options'] = array_map('trim', explode(',', $validated['options']));
        }

        $validated['is_required'] = $request->boolean('is_required');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        FieldDefinition::create($validated);

        return redirect()->route('dashboard.definitions.field-definitions.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function show($id)
    {
        $fieldDefinition = FieldDefinition::findOrFail($id);
        $modules = FieldDefinition::getModuleRegistry();
        $fieldTypes = FieldDefinition::getFieldTypes();
        return view('definitions::field-definitions.show', compact('fieldDefinition', 'modules', 'fieldTypes'));
    }

    public function edit($id)
    {
        $fieldDefinition = FieldDefinition::findOrFail($id);
        $modules = FieldDefinition::getModuleRegistry();
        $fieldTypes = FieldDefinition::getFieldTypes();
        return view('definitions::field-definitions.edit', compact('fieldDefinition', 'modules', 'fieldTypes'));
    }

    public function update(Request $request, $id)
    {
        $fieldDefinition = FieldDefinition::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'module_name' => 'required|string',
            'entity_type' => 'required|string',
            'field_type' => 'required|string|in:' . implode(',', array_keys(FieldDefinition::getFieldTypes())),
            'options' => 'nullable|string',
            'placeholder' => 'nullable|string|max:255',
            'placeholder_ar' => 'nullable|string|max:255',
            'section_label' => 'nullable|string|max:255',
            'section_label_ar' => 'nullable|string|max:255',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Parse options if present
        if (!empty($validated['options'])) {
            $validated['options'] = array_map('trim', explode(',', $validated['options']));
        } else {
            $validated['options'] = null;
        }

        $validated['is_required'] = $request->has('is_required');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $fieldDefinition->update($validated);

        return redirect()->route('dashboard.definitions.field-definitions.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy($id)
    {
        $fieldDefinition = FieldDefinition::findOrFail($id);
        $fieldDefinition->delete();

        return redirect()->route('dashboard.definitions.field-definitions.index')
            ->with('success', __('messages.deleted_successfully'));
    }
}
