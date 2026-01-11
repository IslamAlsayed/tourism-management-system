<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\TouristService;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TouristService\StoreRequest;
use App\Http\Requests\TouristService\UpdateRequest;

class TouristServiceController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.tourist-services.index');
    }

    public function create()
    {
        $siteTypes = config('helpers.site_types') ?: [];
        $categories = config('helpers.categories') ?: [];
        $difficultyLevels = TouristService::getDifficultyLevels();
        $statuses = TouristService::getStatuses();
        return view('pages.dashboard.tourist-services.create', get_defined_vars());
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUser()->id;
        $created = TouristService::create($validated);
        if ($created) {
            if ($request->hasFile('main_image')) {
                $this->uploadPhoto($request, $created, 'main_image', "tourist-services", 'main_image');
            }
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $this->uploadPhoto($image, $created, 'gallery_images', "tourist-services", 'gallery_images');
                }
            }
            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tourist-service')]))
                : redirect()->route('tourist-services.index')->withSuccess(__('messages.type_created', ['type' => __('main.tourist-service')]));
        }
        return redirect()->route('tourist-services.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tourist-service')]));
    }

    public function show($id)
    {
        $touristService = TouristService::with((new TouristService())->getRelationshipNames())->find($id);
        if (!$touristService)
            return redirect()->route('tourist-services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        return view('pages.dashboard.tourist-services.show', compact('touristService'));
    }

    public function edit($id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->route('tourist-services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        $siteTypes = config('helpers.site_types') ?: [];
        $categories = config('helpers.categories') ?: [];
        $difficultyLevels = TouristService::getDifficultyLevels();
        $statuses = TouristService::getStatuses();
        return view('pages.dashboard.tourist-services.edit', get_defined_vars());
    }

    public function update(UpdateRequest $request, $id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->route('tourist-services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        $validated = $request->validated();
        $data = $validated;
        $data['updated_by'] = getActiveUser()->id;

        // Handle main image removal
        if ($request->input('remove_main_image') == '1') {
            if ($touristService->main_image) {
                Storage::disk('public')->delete($touristService->main_image);
                $data['main_image'] = null;
            }
        }

        // Handle gallery images removal
        if ($request->has('remove_gallery_images') && !empty($request->input('remove_gallery_images'))) {
            $removeImages = json_decode($request->input('remove_gallery_images'), true);
            if (is_array($removeImages) && !empty($removeImages)) {
                $currentGallery = $touristService->gallery_images ?? [];
                foreach ($removeImages as $removeImage) {
                    Storage::disk('public')->delete($removeImage);
                    $currentGallery = array_filter($currentGallery, fn($img) => $img !== $removeImage);
                }
                $data['gallery_images'] = array_values($currentGallery);
            }
        }

        $updated = $touristService->update($data);
        if ($request->hasFile('main_image')) {
            $this->uploadPhoto($request, $touristService, 'main_image', "tourist-services");
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $this->uploadPhoto($image, $touristService, 'gallery_images', "tourist-services");
            }
        }
        return $updated
            ? redirect()->route('tourist-services.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tourist-service')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tourist-service')]));
    }

    public function destroy($id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        $deleted = $touristService->delete();
        return $deleted
            ? redirect()->route('tourist-services.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tourist-service')]))
            : redirect()->route('tourist-services.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tourist-service')]));
    }
}