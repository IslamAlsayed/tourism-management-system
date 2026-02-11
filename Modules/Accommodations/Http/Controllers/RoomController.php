<?php

namespace Modules\Accommodations\Http\Controllers;

use Modules\Accommodations\Entities\Room;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Http\Requests\Room\StoreRequest;
use Modules\Accommodations\Http\Requests\Room\UpdateRequest;

class RoomController extends Controller
{
    public function index()
    {
        return view('accommodations::rooms.index');
    }

    public function create()
    {
        return view('accommodations::rooms.create');
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
                : redirect()->route('dashboard.accommodations.rooms.index')->with('success', __('messages.type_created', ['type' => __('main.room')])))
            : redirect()->route('dashboard.accommodations.rooms.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.room')]));
    }

    public function show($id)
    {
        $room = Room::with((new Room)->getRelationshipNames())->find($id);
        if (!$room)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        return view('accommodations::rooms.show', compact('room'));
    }

    public function edit($id)
    {
        $room = Room::find($id);
        if (!$room)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        return view('accommodations::rooms.edit', compact('room'));
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
            ? redirect()->route('dashboard.accommodations.rooms.index')->withSuccess(__('messages.type_updated', ['type' => __('main.room')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.room')]));
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        $deleted = $room->delete();
        return $deleted
            ? redirect()->route('dashboard.accommodations.rooms.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.room')]))
            : redirect()->route('dashboard.accommodations.rooms.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.room')]));
    }
}
