<?php

namespace App\Http\Controllers\Dashboard\Accommodations;

use App\Models\RoomType;
use App\Models\Accommodation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodations\Room\StoreRequest;
use App\Http\Requests\Accommodations\Room\UpdateRequest;

class RoomTypeController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.accommodations.roomTypes.index');
    }

    public function create()
    {
        $accommodations = Accommodation::orderBy('name')->get();
        return view('pages.dashboard.accommodations.roomTypes.create', compact('accommodations'));
    }

    public function store(StoreRequest $request)
    {
        RoomType::create($request->validated());
        return redirect()->route('accommodations.roomTypes.index')->with('success', 'تم إنشاء نوع الغرفة بنجاح!');
    }

    public function edit($id)
    {
        $room = RoomType::find($id);
        if (!$room) {
            return redirect()->route('accommodations.roomTypes.index')->with('error', 'نوع الغرفة غير موجود!');
        }
        $accommodations = Accommodation::orderBy('name')->get();
        return view('pages.dashboard.accommodations.roomTypes.edit', compact('room', 'accommodations'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $room = RoomType::find($id);
        if (!$room) {
            return redirect()->route('accommodations.roomTypes.index')->with('error', 'نوع الغرفة غير موجود!');
        }
        $room->update($request->validated());
        return redirect()->route('accommodations.roomTypes.index')->with('success', 'تم تحديث نوع الغرفة بنجاح!');
    }

    public function destroy($id)
    {
        $room = RoomType::find($id);
        if (!$room) {
            return redirect()->route('accommodations.roomTypes.index')->with('error', 'نوع الغرفة غير موجود!');
        }
        $room->delete();
        return redirect()->route('accommodations.roomTypes.index')->with('success', 'تم حذف نوع الغرفة بنجاح!');
    }

    public function importForm()
    {
        return view('pages.dashboard.accommodations.roomTypes.import');
    }
}