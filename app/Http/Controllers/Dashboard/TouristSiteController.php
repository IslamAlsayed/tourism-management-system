<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\MediaFile;
use App\Models\TouristSite;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TouristSite\StoreRequest;
use App\Http\Requests\TouristSite\UpdateRequest;

class TouristSiteController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tourist-sites.index');
    }

    public function create()
    {
        $difficulty_level = TouristSite::getDifficultyLevels();
        $status = TouristSite::getStatus();
        return view('pages.dashboard.tourist-sites.create', compact('difficulty_level', 'status'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();
        unset($validated['photo'], $validated['gallery']);

        // Handle free entry - nullify all entry fees
        if ($validated['is_free_entry'] ?? false) {
            $validated['entry_fee_adult'] = null;
            $validated['entry_fee_child'] = null;
            $validated['entry_fee_student'] = null;
            $validated['entry_fee_senior'] = null;
            $validated['entry_fee_group'] = null;
            $validated['entry_fee_foreigner_adult'] = null;
            $validated['entry_fee_foreigner_child'] = null;
            $validated['entry_fee_arab_adult'] = null;
            $validated['entry_fee_arab_child'] = null;
            $validated['entry_fee_local_adult'] = null;
            $validated['entry_fee_local_child'] = null;
            $validated['entry_fee_resident_adult'] = null;
            $validated['entry_fee_resident_child'] = null;
        }

        // Handle 24 hours - nullify opening and closing times
        if ($validated['is_24_hours'] ?? false) {
            $validated['opening_time'] = null;
            $validated['closing_time'] = null;
        }

        return DB::transaction(function () use ($validated, $request) {
            $touristSite = TouristSite::create($validated);

            // single photo
            $this->uploadSinglePhoto($request, $touristSite, 'photo', 'tourist-sites');

            // gallery
            $this->uploadGallery($request, $touristSite, 'gallery', 'tourist-sites');

            // remove selected gallery images
            if ($request->filled('removed_gallery')) {
                $removedImages = json_decode($request->removed_gallery, true) ?? [];
                $this->deleteGalleryImages($touristSite, $removedImages, 'gallery');
            }

            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tourist-site')]))
                : redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_created', ['type' => __('main.tourist-site')]));
        });
    }

    public function show($id)
    {
        $touristSite = TouristSite::with((new TouristSite())->getRelationshipNames())->find($id);
        if (!$touristSite)
            return redirect()->route('tourist-sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));
        return view('pages.dashboard.tourist-sites.show', compact('touristSite'));
    }

    public function edit($id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->route('tourist-sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));
        $difficulty_level = TouristSite::getDifficultyLevels();
        $status = TouristSite::getStatus();
        return view('pages.dashboard.tourist-sites.edit', compact('touristSite', 'difficulty_level', 'status'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->route('tourist-sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));

        return DB::transaction(function () use ($request, $touristSite) {
            /* ================= BASIC UPDATE ================= */
            $validated = $request->validated();
            $validated['updated_by'] = getActiveUserId();
            unset($validated['photo'], $validated['gallery']);

            // Handle free entry - nullify all entry fees
            if ($validated['is_free_entry'] ?? false) {
                $validated['entry_fee_adult'] = null;
                $validated['entry_fee_child'] = null;
                $validated['entry_fee_student'] = null;
                $validated['entry_fee_senior'] = null;
                $validated['entry_fee_group'] = null;
                $validated['entry_fee_foreigner_adult'] = null;
                $validated['entry_fee_foreigner_child'] = null;
                $validated['entry_fee_arab_adult'] = null;
                $validated['entry_fee_arab_child'] = null;
                $validated['entry_fee_local_adult'] = null;
                $validated['entry_fee_local_child'] = null;
                $validated['entry_fee_resident_adult'] = null;
                $validated['entry_fee_resident_child'] = null;
            }

            // Handle 24 hours - nullify opening and closing times
            if ($validated['is_24_hours'] ?? false) {
                $validated['opening_time'] = null;
                $validated['closing_time'] = null;
            }

            $updated = $touristSite->update($validated);

            // Handle photo deletion (if remove_photo is checked)
            if ($request->input('remove_photo') == 1 && !empty($touristSite->photo)) {
                Storage::disk('public')->delete($touristSite->photo);
                $touristSite->update(['photo' => null]);
            }

            // Upload new photo if provided
            $this->uploadSinglePhoto($request, $touristSite, 'photo', 'tourist-sites');

            // gallery
            $this->uploadGallery($request, $touristSite, 'gallery', 'tourist-sites');

            // remove selected gallery images
            if ($request->filled('removed_gallery')) {
                $removedImages = json_decode($request->removed_gallery, true) ?? [];
                $this->deleteGalleryImages($touristSite, $removedImages, 'gallery');
            }

            return $updated
                ? redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tourist-site')]))
                : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tourist-site')]));
        });
    }

    public function destroy($id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));

        // Delete associated media files
        $touristSite->media()->delete();

        $deleted = $touristSite->delete();
        return $deleted
            ? redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tourist-site')]))
            : redirect()->route('tourist-sites.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tourist-site')]));
    }
}
