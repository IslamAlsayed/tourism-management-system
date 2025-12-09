<?php

namespace App\Http\Controllers\Dashboard\Accommodations;

use App\Models\AccommodationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\Type\StoreRequest;
use App\Http\Requests\Accommodations\Type\UpdateRequest;

class TypeController extends Controller
{
    /**
     * Display a listing of accommodation types
     */
    public function index()
    {
        return view('pages.dashboard.accommodations.types.index');
    }

    /**
     * Show the form for creating a new type
     */
    public function create()
    {
        return view('pages.dashboard.accommodations.types.create');
    }

    /**
     * Store a newly created type
     */
    public function store(StoreRequest $request)
    {
        AccommodationType::create($request->validated());

        return redirect()
            ->route('accommodations.types.index')
            ->with('success', 'تم إنشاء نوع الإقامة بنجاح!');
    }

    /**
     * Show the form for editing type
     */
    public function edit($id)
    {
        $type = AccommodationType::find($id);
        if (!$type) {
            return redirect()->route('accommodations.types.index')->with('error', 'نوع الإقامة غير موجود!');
        }

        return view('pages.dashboard.accommodations.types.edit', compact('type'));
    }

    /**
     * Update the specified type
     */
    public function update(UpdateRequest $request, $id)
    {
        $type = AccommodationType::find($id);
        if (!$type) {
            return redirect()->route('accommodations.types.index')->with('error', 'نوع الإقامة غير موجود!');
        }
        $type->update($request->validated());

        return redirect()
            ->route('accommodations.types.index')
            ->with('success', 'تم تحديث نوع الإقامة بنجاح!');
    }

    /**
     * Remove the specified type
     */
    public function destroy($id)
    {
        $type = AccommodationType::find($id);
        if (!$type) {
            return redirect()->route('accommodations.types.index')->with('error', 'نوع الإقامة غير موجود!');
        }
        $type->delete();

        return redirect()
            ->route('accommodations.types.index')
            ->with('success', 'تم حذف نوع الإقامة بنجاح!');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('pages.dashboard.accommodations.types.import');
    }
}
