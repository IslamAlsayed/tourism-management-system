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
        if ($request->input('model_type') == 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') == 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
        $room = Room::create($validated);
        if ($room) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.room')]));
            }
            return redirect()->route('rooms.index')->withSuccess(__('messages.type_created', ['type' => __('main.room')]));
        }
        return redirect()->route('rooms.index')->withError(__('messages.type_creation_failed', ['type' => __('main.room')]));
    }

    public function show($id)
    {
        $room = Room::with(['model', 'currency'])->find($id);
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
        $currencies = Currency::orderBy('name')->get(['id', 'name', 'code']);
        return view('pages.dashboard.rooms.edit', compact('room', 'currencies'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        }
        $validated = $request->validated();
        if ($request->input('model_type') === 'restaurant' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Restaurant::class;
        } elseif ($request->input('model_type') === 'accommodation' && $request->filled('model_id')) {
            $validated['model_id'] = $request->input('model_id');
            $validated['model_type'] = Accommodation::class;
        }
        $updated = $room->update($validated);
        if ($updated) {
            return redirect()->route('rooms.index')->withSuccess(__('messages.type_updated', ['type' => __('main.room')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.room')]));
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.room')]));
        }
        $deleted = $room->delete();
        return $deleted
            ? redirect()->route('rooms.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.room')]))
            : redirect()->route('rooms.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.room')]));
    }
}