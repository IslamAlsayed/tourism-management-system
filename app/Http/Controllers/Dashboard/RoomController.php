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
        return redirect()->route('rooms.index')->with('success', 'تم إنشاء نوع الغرفة بنجاح!');
    }

    public function edit($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'نوع الغرفة غير موجود!');
        }
        return view('pages.dashboard.rooms.edit', compact('room'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'نوع الغرفة غير موجود!');
        }
        $room->update($request->validated());
        return redirect()->route('rooms.index')->with('success', 'تم تحديث نوع الغرفة بنجاح!');
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'نوع الغرفة غير موجود!');
        }
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'تم حذف نوع الغرفة بنجاح!');
    }

    public function importForm()
    {
        return view('pages.dashboard.rooms.import');
    }
}