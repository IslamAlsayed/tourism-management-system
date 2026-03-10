<?php

namespace Modules\TouristServices\Http\Controllers;

use Modules\TouristSites\Entities\TouristSite;
use Modules\TouristServices\Entities\TouristService;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use Modules\Core\Entities\PricingDefinition;
use Modules\TouristServices\Http\Requests\TouristService\StoreRequest;
use Modules\TouristServices\Http\Requests\TouristService\UpdateRequest;

class ServiceController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('touristservices::services.index');
    }

    public function create()
    {
        $sites = TouristSite::orderBy('sort_order')->get(['id', 'name']);
        $difficulty_level = TouristService::getDifficultyLevels();
        $currencies = \Modules\Localization\Entities\Currency::orderBy('name')->get(['id', 'name', 'code']);
        $countries = \Modules\Geography\Entities\Country::orderBy('name')->get(['id', 'name']);
        $nationalities = \Modules\Geography\Entities\Nationality::orderBy('name')->get(['id', 'name']);
        $subregions = \Modules\Geography\Entities\Subregion::orderBy('name')->get(['id', 'name']);
        $pricing_units = PricingDefinition::where('category', 'pricing_unit')->where('is_active', true)->get();

        return view(
            'touristservices::services.create',
            compact('sites', 'difficulty_level', 'currencies', 'countries', 'nationalities', 'subregions', 'pricing_units')
        );
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        // dd($request->all(), $validated);

        // === 1. PREPARE MAIN SERVICE DATA ===
        $serviceData = collect($validated)->except([
            'seasonal_prices',
            'season_groups',
            'flat_start_date',
            'flat_end_date',
            'tax_configuration',
            'commission_configuration',
            'target_modules',
            'photo',
            'gallery',
        ])->toArray();

        $serviceData['created_by'] = getActiveUserId();

        // === 2. CREATE TOURIST SERVICE ===
        $touristService = TouristService::create($serviceData);
        if (!$touristService)
            return redirect()->route('dashboard.touristservices.services.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tourist-service')]));

        // === 3. SAVE SEASONAL PRICES ===
        if ($validated['pricing_type'] === 'seasonal' && isset($validated['season_groups'])) {
            $this->storeSeasonalPrices($touristService, $validated['season_groups'], $validated);
        } elseif ($validated['pricing_type'] === 'flat' && isset($validated['seasonal_prices']['Standard'])) {
            // Store flat rate pricing as a single season
            $this->storeFlatPricing($touristService, $validated['seasonal_prices']['Standard'], $validated);
        }

        // === 4. SAVE TAX CONFIGURATIONS ===
        if (!empty($validated['tax_configuration'])) {
            $this->storeTaxConfigurations($touristService, $validated['tax_configuration']);
        }

        // === 5. SAVE COMMISSION CONFIGURATIONS ===
        if (!empty($validated['commission_configuration'])) {
            $this->storeCommissionConfigurations($touristService, $validated['commission_configuration']);
        }

        // === 6. SAVE TARGET MODULES ===
        if (!empty($validated['target_modules'])) {
            $this->storeTargetModules($touristService, $validated['target_modules']);
        }

        if ($touristService && $request->has('custom_fields')) {
            $touristService->saveCustomFields($request->custom_fields);
        }

        // === 7. SAVE MEDIA FILES ===
        $this->uploadSinglePhoto($request, $touristService, 'photo', 'tourist-services');
        $this->uploadGallery($request, $touristService, 'gallery', 'tourist-services');

        // remove selected gallery images
        if ($request->filled('removed_gallery')) {
            $removedImages = json_decode($request->removed_gallery, true) ?? [];
            $this->deleteGalleryImages($touristService, $removedImages, 'gallery');
        }

        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tourist-service')]))
            : redirect()->route('dashboard.touristservices.services.index')->withSuccess(__('messages.type_created', ['type' => __('main.tourist-service')]));
    }

    public function show($id)
    {
        $touristService = TouristService::with((new TouristService())->getRelationshipNames())->find($id);
        if (!$touristService)
            return redirect()->route('dashboard.touristservices.services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        return view('touristservices::services.show', compact('touristService'));
    }

    public function edit($id)
    {
        $touristService = TouristService::with([
            'seasonalPrices',
            'taxConfigurations',
            'commissionConfigurations',
            'modules',
            'operatingSchedules',
            'specialHours'
        ])->find($id);

        if (!$touristService)
            return redirect()->route('dashboard.touristservices.services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));

        $sites = TouristSite::orderBy('sort_order')->get(['id', 'name']);
        $currencies = \Modules\Localization\Entities\Currency::orderBy('name')->get(['id', 'name', 'code']);
        $countries = \Modules\Geography\Entities\Country::orderBy('name')->get(['id', 'name']);
        $nationalities = \Modules\Geography\Entities\Nationality::orderBy('name')->get(['id', 'name']);
        $subregions = \Modules\Geography\Entities\Subregion::orderBy('name')->get(['id', 'name']);
        $pricing_units = PricingDefinition::where('category', 'pricing_unit')->where('is_active', true)->get();

        return view(
            'touristservices::services.edit',
            compact('touristService', 'sites', 'currencies', 'countries', 'nationalities', 'subregions', 'pricing_units')
        );
    }

    public function update(UpdateRequest $request, $id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->route('dashboard.touristservices.services.index')->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));

        $validated = $request->validated();

        // === 1. PREPARE MAIN SERVICE DATA ===
        $serviceData = collect($validated)->except([
            'seasonal_prices',
            'season_groups',
            'flat_start_date',
            'flat_end_date',
            'tax_configuration',
            'commission_configuration',
            'target_modules',
            'photo',
            'gallery',
        ])->toArray();

        $serviceData['updated_by'] = getActiveUserId();

        // === 2. UPDATE TOURIST SERVICE ===
        $updated = $touristService->update($serviceData);

        if (!$updated) {
            return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tourist-service')]));
        }

        // === 3. UPDATE SEASONAL PRICES ===
        // Delete old seasonal prices and recreate
        $touristService->seasonalPrices()->delete();

        if ($validated['pricing_type'] === 'seasonal' && isset($validated['season_groups'])) {
            $this->storeSeasonalPrices($touristService, $validated['season_groups'], $validated);
        } elseif ($validated['pricing_type'] === 'flat' && isset($validated['seasonal_prices']['Standard'])) {
            $this->storeFlatPricing($touristService, $validated['seasonal_prices']['Standard'], $validated);
        }

        // === 4. UPDATE TAX CONFIGURATIONS ===
        $touristService->taxConfigurations()->delete();
        if (!empty($validated['tax_configuration'])) {
            $this->storeTaxConfigurations($touristService, $validated['tax_configuration']);
        }

        // === 5. UPDATE COMMISSION CONFIGURATIONS ===
        $touristService->commissionConfigurations()->delete();
        if (!empty($validated['commission_configuration'])) {
            $this->storeCommissionConfigurations($touristService, $validated['commission_configuration']);
        }

        // === 6. UPDATE TARGET MODULES ===
        $touristService->modules()->delete();
        if (!empty($validated['target_modules'])) {
            $this->storeTargetModules($touristService, $validated['target_modules']);
        }

        if ($touristService && $request->has('custom_fields')) {
            $touristService->saveCustomFields($request->custom_fields);
        }

        // === 7. UPDATE MEDIA FILES ===
        $this->uploadSinglePhoto($request, $touristService, 'photo', 'tourist-services');
        $this->uploadGallery($request, $touristService, 'gallery', 'tourist-services');

        // remove selected gallery images
        if ($request->filled('removed_gallery')) {
            $removedImages = json_decode($request->removed_gallery, true) ?? [];
            $this->deleteGalleryImages($touristService, $removedImages, 'gallery');
        }

        return redirect()->route('dashboard.touristservices.services.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tourist-service')]));
    }

    public function destroy($id)
    {
        $touristService = TouristService::find($id);
        if (!$touristService)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tourist-service')]));
        $deleted = $touristService->delete();
        return $deleted
            ? redirect()->route('dashboard.touristservices.services.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tourist-service')]))
            : redirect()->route('dashboard.touristservices.services.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tourist-service')]));
    }

    /**
     * Store seasonal prices with complete pricing matrix
     */
    private function storeSeasonalPrices($touristService, $seasonGroups, $allValidated = null)
    {
        foreach ($seasonGroups as $groupId => $group) {
            $seasonName = $group['name'] ?? 'Season ' . ($groupId + 1);

            // Extract date ranges
            $startDate = null;
            $endDate = null;
            if (!empty($group['ranges'])) {
                $firstRange = reset($group['ranges']);
                $startDate = $firstRange['start'] ?? null;
                $lastRange = end($group['ranges']);
                $endDate = $lastRange['end'] ?? null;
            }

            // Build pricing matrix from seasonal_prices data
            $pricingMatrix = [];
            if ($allValidated && isset($allValidated['seasonal_prices'][$seasonName])) {
                $pricingMatrix = $allValidated['seasonal_prices'][$seasonName];
            }

            // Ensure notes is a string
            $notes = $group['notes'] ?? null;
            if (is_array($notes)) {
                $notes = json_encode($notes);
            } elseif ($notes !== null && !is_string($notes)) {
                $notes = (string)$notes;
            }

            // Create seasonal price record
            // Laravel will automatically JSON-encode the array due to 'json' cast
            $touristService->seasonalPrices()->create([
                'season_name' => $seasonName,
                'season_start_date' => $startDate ? date('Y-m-d', strtotime($startDate)) : null,
                'season_end_date' => $endDate ? date('Y-m-d', strtotime($endDate)) : null,
                'pricing_matrix' => $pricingMatrix, // Pass as array, cast handles JSON encoding
                'notes' => $notes,
                'sort_order' => $groupId,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Store flat rate pricing
     */
    private function storeFlatPricing($touristService, $pricingData, $validated)
    {
        // Ensure pricingData is an array
        if (!is_array($pricingData)) {
            $pricingData = [];
        }

        // Extract notes if it exists in pricingData
        $notes = null;
        if (isset($pricingData['notes'])) {
            $notes = $pricingData['notes'];
            unset($pricingData['notes']); // Remove from matrix

            // Ensure notes is a string
            if (is_array($notes)) {
                $notes = json_encode($notes);
            } elseif ($notes !== null && !is_string($notes)) {
                $notes = (string)$notes;
            }
        }

        // Date formatting
        $flatStartDate = isset($validated['flat_start_date']) ? date('Y-m-d', strtotime($validated['flat_start_date'])) : null;
        $flatEndDate = isset($validated['flat_end_date']) ? date('Y-m-d', strtotime($validated['flat_end_date'])) : null;

        $touristService->seasonalPrices()->create([
            'season_name' => 'Standard',
            'season_start_date' => $flatStartDate,
            'season_end_date' => $flatEndDate,
            'pricing_matrix' => $pricingData, // Pass as array, cast handles JSON encoding
            'notes' => $notes,
            'sort_order' => 0,
            'is_active' => true,
        ]);
    }

    /**
     * Store tax configurations
     */
    private function storeTaxConfigurations($touristService, $taxConfigs)
    {
        foreach ($taxConfigs as $index => $tax) {
            $touristService->taxConfigurations()->create([
                'name' => $tax['name'] ?? 'Tax ' . ($index + 1),
                'type' => $tax['type'] ?? 'percentage',
                'value' => $tax['value'] ?? 0,
                'description' => $tax['description'] ?? null,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Store commission configurations
     */
    private function storeCommissionConfigurations($touristService, $commissionConfigs)
    {
        foreach ($commissionConfigs as $index => $commission) {
            $touristService->commissionConfigurations()->create([
                'name' => $commission['name'] ?? 'Commission ' . ($index + 1),
                'applies_to' => $commission['applies_to'] ?? 'all',
                'type' => $commission['type'] ?? 'percentage',
                'value' => $commission['value'] ?? 0,
                'description' => $commission['description'] ?? null,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Store target modules
     */
    private function storeTargetModules($touristService, $modules)
    {
        foreach ($modules as $moduleName) {
            $touristService->modules()->create([
                'module_name' => $moduleName,
                'is_active' => true,
            ]);
        }
    }
}
