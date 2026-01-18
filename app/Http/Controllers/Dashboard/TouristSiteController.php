<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\MediaFile;
use App\Models\TouristSite;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
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
        $sites = TouristSite::orderBy('sort_order')->get();
        $cities = City::orderBy('name')->paginate(25, ['id', 'name']);
        return view('pages.dashboard.tourist-sites.create', compact('sites', 'cities'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUser()->id;

        // Remove image fields from validated data (will be handled via MediaFile)
        unset($validated['main_image'], $validated['gallery_images']);

        $created = TouristSite::create($validated);

        if ($created) {
            // Handle main image
            if ($request->hasFile('main_image')) {
                $this->uploadMediaFile($request->file('main_image'), $created, 'main_image');
            }

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $this->uploadMediaFile($file, $created, 'gallery');
                }
            }

            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tourist-site')]))
                : redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_created', ['type' => __('main.tourist-site')]));
        }

        return redirect()->route('tourist-sites.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tourist-site')]));
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
        $sites = TouristSite::where('is_active', true)->get();
        $cities = City::orderBy('name')->paginate(25, ['id', 'name']);
        return view('pages.dashboard.tourist-sites.edit', compact('touristSite', 'sites', 'cities'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->route('tourist-sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));

        $validated = $request->validated();

        // Remove image fields from validated data (will be handled via MediaFile)
        unset($validated['main_image'], $validated['gallery_images']);

        $data = $validated;
        $data['updated_by'] = getActiveUser()->id;

        // Handle remove_main_image
        if ($request->has('remove_main_image') && $request->get('remove_main_image') == '1') {
            $touristSite->media()->where('collection_name', 'main_image')->delete();
        }

        // Handle upload new main image
        if ($request->hasFile('main_image')) {
            // Delete old main image
            $touristSite->media()->where('collection_name', 'main_image')->delete();
            $this->uploadMediaFile($request->file('main_image'), $touristSite, 'main_image');
        }

        // Handle remove_gallery_images
        if ($request->has('remove_gallery_images') && !empty($request->get('remove_gallery_images'))) {
            $removedImages = json_decode($request->get('remove_gallery_images'), true);
            if (is_array($removedImages)) {
                foreach ($removedImages as $imageId) {
                    MediaFile::destroy($imageId);
                }
            }
        }

        // Handle upload new gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $this->uploadMediaFile($file, $touristSite, 'gallery');
            }
        }

        $updated = $touristSite->update($data);

        return $updated
            ? redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tourist-site')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tourist-site')]));
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

    /**
     * Upload media file to MediaFile table
     */
    private function uploadMediaFile($file, $model, $collection)
    {
        try {
            $path = $file->store('tourist-sites', 'public');
            $mimeType = $file->getMimeType();
            $fileType = strpos($mimeType, 'image') !== false ? 'image' : 'file';

            // Get image dimensions if it's an image
            $dimensions = [];
            if ($fileType === 'image') {
                try {
                    $imageInfo = getimagesize($file->getRealPath());
                    if ($imageInfo) {
                        $dimensions = ['width' => $imageInfo[0], 'height' => $imageInfo[1]];
                    }
                } catch (\Exception $e) {
                    // If we can't get dimensions, continue without them
                }
            }

            MediaFile::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
                'file_size' => $file->getSize(),
                'disk' => 'public',
                'collection_name' => $collection,
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'width' => $dimensions['width'] ?? null,
                'height' => $dimensions['height'] ?? null,
                'uploaded_by' => getActiveUser()->id,
                'uploaded_at' => now(),
                'is_active' => true,
            ]);

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Media upload failed: ' . $e->getMessage());
            return false;
        }
    }
}