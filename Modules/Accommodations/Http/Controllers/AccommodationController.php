<?php

namespace Modules\Accommodations\Http\Controllers;

use Modules\Accommodations\Entities\Meal;
use Modules\Accommodations\Entities\Room;
use Modules\Accommodations\Entities\Type;
use Modules\Accommodations\Entities\Season;
use Modules\Accommodations\Entities\Supplement;
use Modules\Accommodations\Entities\Accommodation;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Accommodations\Http\Requests\Accommodations\StoreRequest;
use Modules\Accommodations\Http\Requests\Accommodations\UpdateRequest;

class AccommodationController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('accommodations::accommodations.index');
    }

    public function create()
    {
        $types = Type::orderBy('name')->get();
        return view('accommodations::accommodations.create', compact('types'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        // Create accommodation (basic fields only)
        $accommodation = Accommodation::create($request->except(['seasons', 'rooms', 'meals', 'supplements']));

        // SEASONS
        if (!empty($validated['seasons'])) {
            foreach ($validated['seasons'] as $seasonData) {
                $seasonData['model_id'] = $accommodation->id;
                $seasonData['model_type'] = Accommodation::class;
                Season::create($seasonData);
            }
        }

        // ROOMS
        if (!empty($validated['rooms'])) {
            foreach ($validated['rooms'] as $roomData) {
                $roomData['model_id'] = $accommodation->id;
                $roomData['model_type'] = Accommodation::class;
                Room::create($roomData);
            }
        }

        // MEALS
        if (!empty($validated['meals'])) {
            foreach ($validated['meals'] as $mealData) {
                $mealData['model_id'] = $accommodation->id;
                $mealData['model_type'] = Accommodation::class;
                Meal::create($mealData);
            }
        }

        // SUPPLEMENTS
        if (!empty($validated['supplements'])) {
            foreach ($validated['supplements'] as $supplementData) {
                $supplementData['model_id'] = $accommodation->id;
                $supplementData['model_type'] = Accommodation::class;
                Supplement::create($supplementData);
            }
        }

        if ($accommodation && $request->has('custom_fields')) {
            $accommodation->saveCustomFields($request->custom_fields);
        }

        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.accommodation')]))
            : redirect()->route('dashboard.accommodations.index')->withSuccess(__('messages.type_created', ['type' => __('main.accommodation')]));
    }

    public function show($id)
    {
        $accommodation = Accommodation::with((new Accommodation())->getRelationshipNames())->find($id);
        if (!$accommodation)
            return redirect()->route('dashboard.accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        return view('accommodations::accommodations.show', compact('accommodation'));
    }

    public function edit($id)
    {
        $accommodation = Accommodation::with((new Accommodation())->getRelationshipNames())->find($id);
        if (!$accommodation)
            return redirect()->route('dashboard.accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        $types = Type::orderBy('name')->get();
        return view('accommodations::accommodations.edit', compact('accommodation', 'types'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation)
            return redirect()->route('dashboard.accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        $validated = $request->validated();
        $validated = array_merge($validated, $request->safe()->except(['photo', 'seasons', 'rooms', 'meals', 'supplements']));
        $updated = $accommodation->update($validated);

        if ($request->has('photo')) {
            $this->uploadPhoto($request, $accommodation, 'photo', 'accommodations');
        }

        // EDIT SEASONS
        if (!empty($validated['seasons'])) {
            $accommodation->seasons()->where('model_type', Accommodation::class)->where('model_id', $accommodation->id)->delete();
            foreach ($validated['seasons'] as $seasonData) {
                $seasonData['model_id'] = $accommodation->id;
                $seasonData['model_type'] = Accommodation::class;
                Season::create($seasonData);
            }
        }

        // EDIT ROOMS
        if (!empty($validated['rooms'])) {
            $accommodation->rooms()->where('model_type', Accommodation::class)->where('model_id', $accommodation->id)->delete();
            foreach ($validated['rooms'] as $roomData) {
                $roomData['model_id'] = $accommodation->id;
                $roomData['model_type'] = Accommodation::class;
                Room::create($roomData);
            }
        }

        // EDIT MEALS
        if (!empty($validated['meals'])) {
            $accommodation->meals()->where('model_type', Accommodation::class)->where('model_id', $accommodation->id)->delete();
            foreach ($validated['meals'] as $mealData) {
                $mealData['model_id'] = $accommodation->id;
                $mealData['model_type'] = Accommodation::class;
                Meal::create($mealData);
            }
        }

        // EDIT SUPPLEMENTS
        if (!empty($validated['supplements'])) {
            $accommodation->supplements()->where('model_type', Accommodation::class)->where('model_id', $accommodation->id)->delete();
            foreach ($validated['supplements'] as $supplementData) {
                $supplementData['model_id'] = $accommodation->id;
                $supplementData['model_type'] = Accommodation::class;
                Supplement::create($supplementData);
            }
        }

        if ($accommodation && $request->has('custom_fields')) {
            $accommodation->saveCustomFields($request->custom_fields);
        }

        return $updated
            ? redirect()->route('dashboard.accommodations.index')->withSuccess(__('messages.type_updated', ['type' => __('main.accommodation')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.accommodation')]));
    }

    public function destroy($id)
    {
        $accommodation = Accommodation::find($id);
        if (!$accommodation)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.accommodation')]));
        $deleted = $accommodation->delete();
        return $deleted
            ? redirect()->route('dashboard.accommodations.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.accommodation')]))
            : redirect()->route('dashboard.accommodations.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.accommodation')]));
    }
}
