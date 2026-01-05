<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Currency;
use App\Models\TouristSite;
use App\Traits\PhotoUploadTrait;
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
        $currencies = Currency::orderBy('name')->get();
        $siteTypes = config('helpers.site_types') ?: [];
        $categories = config('helpers.categories') ?: [];
        $difficultyLevels = TouristSite::getDifficultyLevels();
        $statuses = TouristSite::getStatuses();
        return view('pages.dashboard.tourist-sites.create', get_defined_vars());
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except(['main_image', 'gallery_images']));

        $data['created_by'] = getActiveUser()->id;
        $created = TouristSite::create($data);
        if ($created) {
            if ($request->hasFile('main_image')) {
                $this->uploadPhoto($request, $created, 'main_image', "tourist-sites", 'main_image');
            }
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $this->uploadPhoto($image, $created, 'gallery_images', "tourist-sites", 'gallery_images');
                }
            }
            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tourist_site')]))
                : redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_created', ['type' => __('main.tourist_site')]));
        }
        return redirect()->route('tourist-sites.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tourist_site')]));
    }

    public function show($id)
    {
        $touristSite = TouristSite::with((new TouristSite())->getRelationshipNames())->find($id);
        if (!$touristSite)
            return redirect()->route('tourist-sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        return view('pages.dashboard.tourist-sites.show', compact('touristSite'));
    }

    public function edit($id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->route('tourist-sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        $currencies = Currency::orderBy('name')->get();
        $siteTypes = config('helpers.site_types') ?: [];
        $categories = config('helpers.categories') ?: [];
        $difficultyLevels = TouristSite::getDifficultyLevels();
        $statuses = TouristSite::getStatuses();
        return view('pages.dashboard.tourist-sites.edit', get_defined_vars());
    }

    public function update(UpdateRequest $request, $id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->route('tourist-sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except(['main_image', 'gallery_images', 'remove_main_image', 'remove_gallery_images']));

        $data['updated_by'] = getActiveUser()->id;

        // Handle main image removal
        if ($request->input('remove_main_image') == '1') {
            if ($touristSite->main_image) {
                Storage::disk('public')->delete($touristSite->main_image);
                $data['main_image'] = null;
            }
        }

        // Handle gallery images removal
        if ($request->has('remove_gallery_images') && !empty($request->input('remove_gallery_images'))) {
            $removeImages = json_decode($request->input('remove_gallery_images'), true);
            if (is_array($removeImages) && !empty($removeImages)) {
                $currentGallery = $touristSite->gallery_images ?? [];
                foreach ($removeImages as $removeImage) {
                    Storage::disk('public')->delete($removeImage);
                    $currentGallery = array_filter($currentGallery, fn($img) => $img !== $removeImage);
                }
                $data['gallery_images'] = array_values($currentGallery);
            }
        }

        $updated = $touristSite->update($data);
        if ($request->hasFile('main_image')) {
            $this->uploadPhoto($request, $touristSite, 'main_image', "tourist-sites");
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $this->uploadPhoto($image, $touristSite, 'gallery_images', "tourist-sites");
            }
        }
        return $updated
            ? redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tourist_site')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tourist_site')]));
    }

    public function destroy($id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tourist_site')]));
        $deleted = $touristSite->delete();
        return $deleted
            ? redirect()->route('tourist-sites.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tourist_site')]))
            : redirect()->route('tourist-sites.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tourist_site')]));
    }
}