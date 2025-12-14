<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Room;
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
        return view('pages.dashboard.rooms.create');
    }

    public function store(StoreRequest $request)
    {
        Room::create($request->validated());
        return redirect()->route('rooms.index')->withSuccess(__('messages.type_created', ['type' => __('main.room')]));
    }

    public function show($id)
    {
        $room = Room::with('roomRates')->find($id);
        if (!$room) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        }
        return view('pages.dashboard.rooms.show', compact('room'));
    }

    public function edit($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        }
        return view('pages.dashboard.rooms.edit', compact('room'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        }
        $room->update($request->validated());
        return redirect()->route('rooms.index')->withSuccess(__('messages.type_updated', ['type' => __('main.room')]));
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        }
        $deleted = $room->delete();
        if ($deleted) {
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.room')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.room')]));
    }
}