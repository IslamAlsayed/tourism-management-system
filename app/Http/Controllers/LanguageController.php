<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Http\Requests\Languages\LanguageCreateRequest;
use App\Http\Requests\Languages\LanguageUpdateRequest;

class LanguageController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.languages.index');
    }

    public function create()
    {
        return view('pages.dashboard.languages.create');
    }

    public function store(LanguageCreateRequest $request)
    {
        $validated = $request->validated();
        $created = Language::create($validated);

        if ($created) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.language')]));
            }
            return redirect()->route('languages.index')->with('success', __('main.messages.type_created', ['type' => __('main.language')]));
        }

        return redirect()->route('languages.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.language')]));
    }

    public function edit($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.language')]));
        }
        return view('pages.dashboard.languages.edit', compact('language'));
    }

    public function update(LanguageUpdateRequest $request, $id)
    {
        $language = Language::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.language')]));
        }
        $validated = $request->validated();

        $updated = $language->update($validated);
        if ($updated) {
            return redirect()->route('languages.index')->with('success', __('main.messages.type_updated', ['type' => __('main.language')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.language')]));
    }

    public function destroy($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.language')]));
        }
        $deleted = $language->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.language')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.language')]));
    }
}