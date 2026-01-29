<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Jeep;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TransportationCompany;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Jeep\StoreRequest;
use App\Http\Requests\Jeep\UpdateRequest;

class JeepController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        $jeeps = Jeep::with('currency')->latest()->paginate(10);
        return view('pages.dashboard.jeeps.index', compact('jeeps'));
    }

    public function create()
    {
        $companies = TransportationCompany::orderBy('name')->get();
        $durationUnits = Jeep::DURATION_UNITS;
        $distanceUnits = Jeep::DISTANCE_UNITS;
        $priceTypes = Jeep::PRICE_TYPES;
        return view('pages.dashboard.jeeps.create', compact('companies', 'durationUnits', 'distanceUnits', 'priceTypes'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();
        unset($validated['photo'], $validated['gallery']);

        // Extract seasons
        $seasons = $validated['seasons'] ?? [];
        unset($validated['seasons']);

        return DB::transaction(function () use ($validated, $seasons, $request) {
            $jeep = Jeep::create($validated);

            // single photo
            $this->uploadSinglePhoto($request, $jeep, 'photo', 'jeeps');

            // gallery
            $this->uploadGallery($request, $jeep, 'gallery', 'jeeps');

            // remove selected gallery images
            if ($request->filled('removed_gallery')) {
                $removedImages = json_decode($request->removed_gallery, true) ?? [];
                $this->deleteGalleryImages($jeep, $removedImages, 'gallery');
            }

            // Handle seasons
            foreach ($seasons as $seasonData) {
                $nationalityPrices = $seasonData['nationality_prices'] ?? [];
                unset($seasonData['nationality_prices']);

                $season = $jeep->seasons()->create($seasonData);

                if (!empty($nationalityPrices)) {
                    $season->nationalityPrices()->createMany(array_values($nationalityPrices));
                }
            }

            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.jeep')]))
                : redirect()->route('jeeps.index')->withSuccess(__('messages.type_created', ['type' => __('main.jeep')]));
        });
    }

    public function show($id)
    {
        $jeep = Jeep::with((new Jeep())->getRelationshipNames())->find($id);
        if (!$jeep)
            return redirect()->route('jeeps.index')->withError(__('messages.not_found_this_type', ['type' => __('main.jeep')]));
        return view('pages.dashboard.jeeps.show', compact('jeep'));
    }

    public function edit($id)
    {
        $jeep = Jeep::find($id);
        if (!$jeep)
            return redirect()->route('jeeps.index')->withError(__('messages.not_found_this_type', ['type' => __('main.jeep')]));
        $companies = TransportationCompany::orderBy('name')->get();
        $durationUnits = Jeep::DURATION_UNITS;
        $distanceUnits = Jeep::DISTANCE_UNITS;
        $priceTypes = Jeep::PRICE_TYPES;
        return view('pages.dashboard.jeeps.edit', compact('jeep', 'companies', 'durationUnits', 'distanceUnits', 'priceTypes'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $jeep = Jeep::find($id);
        if (!$jeep)
            return redirect()->route('jeeps.index')->withError(__('messages.not_found_this_type', ['type' => __('main.jeep')]));

        return DB::transaction(function () use ($request, $jeep) {

            /* ================= BASIC UPDATE ================= */
            $data = $request->validated();
            $data['updated_by'] = getActiveUserId();

            unset($data['photo'], $data['gallery'], $data['seasons']);

            $updated = $jeep->update($data);

            // Handle photo deletion (if remove_photo is checked)
            if ($request->input('remove_photo') == 1 && !empty($jeep->photo)) {
                Storage::disk('public')->delete($jeep->photo);
                $jeep->update(['photo' => null]);
            }

            // Upload new photo if provided
            $this->uploadSinglePhoto($request, $jeep, 'photo', 'jeeps');

            // gallery
            $this->uploadGallery($request, $jeep, 'gallery', 'jeeps');

            // remove selected gallery images
            if ($request->filled('removed_gallery')) {
                $removedImages = json_decode($request->removed_gallery, true) ?? [];
                $this->deleteGalleryImages($jeep, $removedImages, 'gallery');
            }

            /* ================= SEASONS ================= */

            $jeep->seasons()->delete();

            foreach ($request->input('seasons', []) as $seasonData) {
                $prices = $seasonData['nationality_prices'] ?? [];
                unset($seasonData['nationality_prices']);

                $season = $jeep->seasons()->create($seasonData);

                if ($prices) {
                    $season->nationalityPrices()->createMany(array_values($prices));
                }
            }

            return $updated
                ? redirect()->route('jeeps.index')->withSuccess(__('messages.type_updated', ['type' => __('main.jeep')]))
                : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.jeep')]));
        });
    }

    public function destroy($id)
    {
        $jeep = Jeep::find($id);
        if (!$jeep)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.jeep')]));
        $jeep->media()->delete();
        $deleted = $jeep->delete();
        return $deleted
            ? redirect()->route('jeeps.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.jeep')]))
            : redirect()->route('jeeps.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.jeep')]));
    }
}
