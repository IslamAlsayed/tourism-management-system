<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Type;
use App\Http\Controllers\Controller;
use App\Http\Requests\Type\StoreRequest;
use App\Http\Requests\Type\UpdateRequest;

class TypeController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.types.index');
    }

    public function create()
    {
        return view('pages.dashboard.types.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = Type::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.type')]))
                : redirect()->route('types.index')->with('success', __('messages.type_created', ['type' => __('main.type')])))
            : redirect()->route('types.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.type')]));
    }

    public function show($id)
    {
        $type = Type::with((new Type)->getRelationshipNames())->find($id);
        if (!$type)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        return view('pages.dashboard.types.show', compact('type'));
    }

    public function edit($id)
    {
        $type = Type::find($id);
        if (!$type)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        return view('pages.dashboard.types.edit', compact('type'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $type = Type::find($id);
        if (!$type)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        $validated = $request->validated();
        $updated = $type->update($validated);
        return $updated
            ? redirect()->route('types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.type')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.type')]));
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        if (!$type)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        $deleted = $type->delete();
        return $deleted
            ? redirect()->route('types.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.type')]))
            : redirect()->route('types.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.type')]));
    }
}