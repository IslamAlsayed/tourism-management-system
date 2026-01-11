<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Room;
use App\Models\Currency;
use App\Models\Restaurant;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRequest;
use App\Http\Requests\Room\UpdateRequest;

class RoomController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.rooms.index');
    }

    public function create()
    {
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.rooms.create', compact('currencies'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $created = Room::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.room')]))
                : redirect()->route('rooms.index')->with('success', __('messages.type_created', ['type' => __('main.room')])))
            : redirect()->route('rooms.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.room')]));
    }

    public function show($id)
    {
        $room = Room::with((new Room)->getRelationshipNames())->find($id);
        if (!$room)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        return view('pages.dashboard.rooms.show', compact('room'));
    }

    public function edit($id)
    {
        $room = Room::find($id);
        if (!$room)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.rooms.edit', compact('room', 'currencies'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $room = Room::find($id);
        if (!$room)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        $validated = $request->validated();
        $validated['model_id'] = $request->input('model_id');
        $validated['model_type'] = "App\\Models\\" . studlyCaseName($request->input('model_type'));
        $updated = $room->update($validated);
        return $updated
            ? redirect()->route('rooms.index')->withSuccess(__('messages.type_updated', ['type' => __('main.room')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.room')]));
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        $deleted = $room->delete();
        return $deleted
            ? redirect()->route('rooms.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.room')]))
            : redirect()->route('rooms.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.room')]));
    }
}