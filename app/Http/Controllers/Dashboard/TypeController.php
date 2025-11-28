<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:types,name',
            'name_ar' => 'required|string|max:255',
        ]);

        $type = Type::create($validated);

        if ($type) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.type')]));
            }
            return redirect()->route('types.index')->withSuccess(__('messages.type_created', ['type' => __('main.type')]));
        }

        return redirect()->route('types.index')->withError(__('messages.type_creation_failed', ['type' => __('main.type')]));
    }

    public function edit($id)
    {
        $type = Type::find($id);
        if (!$type) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        }
        return view('pages.dashboard.types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = Type::find($id);
        if (!$type) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:255|unique:types,name,' . $type->id,
            'name_ar' => 'nullable|string|max:255',
        ]);

        $updated = $type->update($validated);

        if ($updated) {
            return redirect()->route('types.index')->withSuccess(__('messages.type_updated', ['type' => __('main.type')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.type')]));
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        if (!$type) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.type')]));
        }
        $deleted = $type->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.type')]));
        }

        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.type')]));
    }
}