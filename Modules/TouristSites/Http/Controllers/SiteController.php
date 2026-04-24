<?php

namespace Modules\TouristSites\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\TouristSites\Entities\TouristSite;
use Modules\TouristSites\Entities\TouristSiteEntryFee;
use Modules\TouristSites\Http\Requests\TouristSite\StoreRequest;
use Modules\TouristSites\Http\Requests\TouristSite\UpdateRequest;
use Modules\Geography\Entities\Nationality;
use Modules\Geography\Entities\Subregion;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\Country;
use Modules\TravelDocuments\Entities\TravelPasse;
use Modules\TouristSites\Entities\Facility;
use Modules\Core\Entities\PricingDefinition;

class SiteController extends Controller
{
    use PhotoUploadTrait;

    public function __construct()
    {
        $this->authorizeResource(TouristSite::class, 'site');
    }

    public function index()
    {
        return view('touristsites::sites.index');
    }

    public function create()
    {
        $difficulty_level = TouristSite::getDifficultyLevels();
        $status = TouristSite::getStatus();
        $nationalities = Nationality::where('is_active', true)->get();
        $travelPasses = TravelPasse::where('is_active', true)->orderBy('name')->get();
        $facilities = Facility::active()->orderBy('sort_order')->get();
        $pricing_units = PricingDefinition::where('category', 'pricing_unit')->where('is_active', true)->get();
        $site_types = PricingDefinition::where('category', 'site_type')->where('is_active', true)->get();
        $site_categories = PricingDefinition::where('category', 'site_category')->where('is_active', true)->get();
        $supplier_types = PricingDefinition::where('category', 'supplier_type')->where('is_active', true)->get();
        $site_themes = PricingDefinition::where('category', 'site_theme')->where('is_active', true)->get();

        return view('touristsites::sites.create', compact(
            'difficulty_level',
            'status',
            'nationalities',
            'travelPasses',
            'facilities',
            'pricing_units',
            'site_types',
            'site_categories',
            'supplier_types',
            'site_themes'
        ));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();
        $validated['average_rating'] = 0;
        $validated['total_reviews'] = 0;
        $validated['popularity_score'] = 0;
        $validated['estimated_visit_duration'] = 0;
        $validated['difficulty_level'] = $validated['difficulty_level'] ?? 'easy';
        $validated['status'] = $validated['status'] ?? 'active';
        $nationalityEntryFees = $validated['nationality_entry_fees'] ?? [];
        $travelPasses = $validated['travel_passes'] ?? [];
        $facilities = $validated['facilities'] ?? [];
        unset($validated['photo'], $validated['gallery'], $validated['nationality_entry_fees'], $validated['travel_passes'], $validated['facilities']);

        // Convert multi-select arrays to comma-separated strings
        foreach (['site_type', 'category', 'supplier_type', 'sites_theme'] as $field) {
            if (isset($validated[$field]) && is_array($validated[$field])) {
                $validated[$field] = implode(',', $validated[$field]);
            }
        }

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
            $nationalityEntryFees = [];
        }

        // Handle 24 hours - nullify opening and closing times
        if ($validated['is_24_7'] ?? false) {
            $validated['opening_time'] = null;
            $validated['closing_time'] = null;
        }

        return DB::transaction(function () use ($validated, $request, $nationalityEntryFees, $facilities, $travelPasses) {
            $touristSite = TouristSite::create($validated);

            // Sync nationality entry fees
            $this->syncNationalityEntryFees($touristSite, $nationalityEntryFees);

            // Sync facilities
            $touristSite->facilities()->sync($facilities);

            // Sync travel passes
            if (($validated['has_unified_ticket'] ?? 0) == 1) {
                $touristSite->travelPasses()->sync($travelPasses);
            }

            if ($touristSite && $request->has('custom_fields')) {
                $touristSite->saveCustomFields($request->custom_fields);
            }

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
                : redirect()->route('dashboard.touristsites.sites.index')->withSuccess(__('messages.type_created', ['type' => __('main.tourist-site')]));
        });
    }

    public function show($id)
    {
        $touristSite = TouristSite::with((new TouristSite())->getRelationshipNames())->find($id);
        if (!$touristSite)
            return redirect()->route('dashboard.touristsites.sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));
        return view('touristsites::sites.show', compact('touristSite'));
    }

    public function edit($id)
    {
        $touristSite = TouristSite::with(['nationalityEntryFees', 'travelPasses', 'holidays', 'seasonalHours'])->find($id);
        if (!$touristSite)
            return redirect()->route('dashboard.touristsites.sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));
        $difficulty_level = TouristSite::getDifficultyLevels();
        $status = TouristSite::getStatus();
        $nationalities = Nationality::where('is_active', true)->with('country')->get();
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        $subregions = Subregion::where('is_active', true)->orderBy('name')->get();
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $travelPasses = TravelPasse::where('is_active', true)->orderBy('name')->get();
        $facilities = Facility::active()->orderBy('sort_order')->get();
        $pricing_units = PricingDefinition::where('category', 'pricing_unit')->where('is_active', true)->get();
        $site_types = PricingDefinition::where('category', 'site_type')->where('is_active', true)->get();
        $site_categories = PricingDefinition::where('category', 'site_category')->where('is_active', true)->get();
        $supplier_types = PricingDefinition::where('category', 'supplier_type')->where('is_active', true)->get();
        $site_themes = PricingDefinition::where('category', 'site_theme')->where('is_active', true)->get();
        return view('touristsites::sites.edit', compact('touristSite', 'difficulty_level', 'status', 'nationalities', 'regions', 'subregions', 'countries', 'travelPasses', 'facilities', 'pricing_units', 'site_types', 'site_categories', 'supplier_types', 'site_themes'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $touristSite = TouristSite::find($id);
        if (!$touristSite)
            return redirect()->route('dashboard.touristsites.sites.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-site')]));

        return DB::transaction(function () use ($request, $touristSite) {
            /* ================= BASIC UPDATE ================= */
            $validated = $request->validated();
            $validated['updated_by'] = getActiveUserId();
            
            // Extract relations not in main table
            $nationalityEntryFees = $validated['nationality_entry_fees'] ?? [];
            $travelPasses = $validated['travel_passes'] ?? [];
            $facilities = $validated['facilities'] ?? [];
            $holidays = $validated['holidays'] ?? [];
            $seasonalHours = $validated['seasonal_hours'] ?? [];
            unset($validated['photo'], $validated['gallery'], $validated['nationality_entry_fees'], $validated['travel_passes'], $validated['facilities'], $validated['holidays'], $validated['seasonal_hours']);

            // Convert multi-select arrays to comma-separated strings
            foreach (['site_type', 'category', 'supplier_type', 'sites_theme'] as $field) {
                if (isset($validated[$field]) && is_array($validated[$field])) {
                     $validated[$field] = implode(',', $validated[$field]);
                }
            }

            // Ensure special_hours is handled correctly
            if (isset($validated['special_hours']) && is_string($validated['special_hours'])) {
                $validated['special_hours'] = json_decode($validated['special_hours'], true);
            }

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
                $nationalityEntryFees = [];
            }

            // Handle 24 hours - nullify opening and closing times
            if ($validated['is_24_7'] ?? false) {
                $validated['opening_time'] = null;
                $validated['closing_time'] = null;
            }

            $updated = $touristSite->update($validated);

            // Sync facilities
            $touristSite->facilities()->sync($facilities);

            // Sync travel passes
            if (($validated['has_unified_ticket'] ?? 0) == 1) {
                 $touristSite->travelPasses()->sync($travelPasses);
            } else {
                 $touristSite->travelPasses()->detach();
            }

            if ($touristSite && $request->has('custom_fields')) {
                $touristSite->saveCustomFields($request->custom_fields);
            }

            // Sync nationality entry fees
            $this->syncNationalityEntryFees($touristSite, $nationalityEntryFees);

            // Sync holidays (delete old, create new)
            $this->syncHolidays($touristSite, $holidays);

            // Sync seasonal hours (delete old, create new)
            $this->syncSeasonalHours($touristSite, $seasonalHours);

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
                ? redirect()->route('dashboard.touristsites.sites.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tourist-site')]))
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
            ? redirect()->route('dashboard.touristsites.sites.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tourist-site')]))
            : redirect()->route('dashboard.touristsites.sites.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tourist-site')]));
    }

    /**
     * Sync nationality entry fees for a tourist site.
     */
    private function syncNationalityEntryFees(TouristSite $touristSite, array $fees): void
    {
        // Delete existing fees
        $touristSite->nationalityEntryFees()->delete();

        // Create new fees
        foreach ($fees as $fee) {
            if (!empty($fee['nationality_id']) && (!empty($fee['adult_price']) || !empty($fee['child_price']))) {
                $touristSite->nationalityEntryFees()->create([
                    'nationality_id' => $fee['nationality_id'],
                    'adult_price' => $fee['adult_price'] ?? null,
                    'child_price' => $fee['child_price'] ?? null,
                ]);
            }
        }
    }

    /**
     * Sync holidays for a tourist site.
     */
    private function syncHolidays(TouristSite $touristSite, array $holidays): void
    {
        // Delete existing holidays
        $touristSite->holidays()->delete();

        // Create new holidays
        foreach ($holidays as $holiday) {
            if (empty($holiday['type'])) continue;

            $touristSite->holidays()->create([
                'type' => $holiday['type'],
                'day_of_week' => $holiday['day_of_week'] ?? null,
                'holiday_date' => $holiday['holiday_date'] ?? null,
                'name' => $holiday['name'] ?? null,
                'name_ar' => $holiday['name_ar'] ?? null,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Sync seasonal hours for a tourist site.
     */
    private function syncSeasonalHours(TouristSite $touristSite, array $seasonalHours): void
    {
        // Delete existing seasonal hours
        $touristSite->seasonalHours()->delete();

        // Create new seasonal hours
        foreach ($seasonalHours as $sh) {
            if (empty($sh['season_name']) || empty($sh['start_date']) || empty($sh['end_date'])) continue;

            $touristSite->seasonalHours()->create([
                'season_name' => $sh['season_name'],
                'season_name_ar' => $sh['season_name_ar'] ?? null,
                'start_date' => $sh['start_date'],
                'end_date' => $sh['end_date'],
                'opening_time' => $sh['opening_time'] ?? null,
                'closing_time' => $sh['closing_time'] ?? null,
                'is_closed' => $sh['is_closed'] ?? false,
                'notes' => $sh['notes'] ?? null,
                'is_active' => true,
            ]);
        }
    }
}
