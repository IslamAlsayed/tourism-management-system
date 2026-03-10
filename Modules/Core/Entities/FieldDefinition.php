<?php

namespace Modules\Core\Entities;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FieldDefinition extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'code',
        'name',
        'name_ar',
        'module_name',
        'entity_type',
        'field_type',
        'options',
        'placeholder',
        'placeholder_ar',
        'section_label',
        'section_label_ar',
        'is_required',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Define columns for the dashboard table.
     */
    public function getTableColumns(): array
    {
        return [
            'id' => ['label' => 'ID', 'sortable' => true],
            'code' => ['label' => 'Code', 'sortable' => true],
            'name' => ['label' => __('main.name'), 'sortable' => true],
            'name_ar' => ['label' => __('main.name_ar'), 'sortable' => true],
            'module_name' => ['label' => __('main.module'), 'sortable' => true],
            'field_type' => ['label' => __('main.field_type'), 'sortable' => true],
            'is_active' => ['label' => __('main.status'), 'sortable' => true],
        ];
    }

    // ──────────────────────────────────────────
    // Auto-generate code on create
    // ──────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->code)) {
                $lastId = static::max('id') ?? 0;
                $item->code = 'FD-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => app()->getLocale() === 'ar' && !empty($this->name_ar) ? $this->name_ar : $this->name,
        );
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────
    public function values()
    {
        return $this->hasMany(CustomFieldValue::class);
    }

    // ──────────────────────────────────────────
    // Search Config
    // ──────────────────────────────────────────
    public function getExcludedColumns()
    {
        return ['options', 'placeholder', 'placeholder_ar', 'section_label', 'section_label_ar'];
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────
    public function scopeForModule($query, $moduleName)
    {
        return $query->where('module_name', $moduleName);
    }

    public function scopeForEntity($query, $entityType)
    {
        return $query->where('entity_type', $entityType);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ──────────────────────────────────────────
    // Registry — All supported modules/entities
    // ──────────────────────────────────────────
    public static function getModuleRegistry(): array
    {
        return [
            // ── Core ──
            'core' => [
                'label' => 'Core / System',
                'entities' => [
                    'User' => 'User',
                    'PricingDefinition' => 'Pricing Definition',
                    'Setting' => 'Setting',
                ],
            ],

            // ── Geography ──
            'geography' => [
                'label' => 'Geography',
                'entities' => [
                    'Country' => 'Country',
                    'State' => 'State / Province',
                    'City' => 'City',
                    'Region' => 'Region',
                    'Subregion' => 'Sub-region',
                    'Nationality' => 'Nationality',
                ],
            ],

            // ── Localization ──
            'localization' => [
                'label' => 'Localization',
                'entities' => [
                    'Currency' => 'Currency',
                    'Language' => 'Language',
                    'Timezone' => 'Timezone',
                ],
            ],

            // ── Tour Guides ──
            'tour_guides' => [
                'label' => 'Tour Guides',
                'entities' => [
                    'TourGuide' => 'Tour Guide',
                    'TourGuideType' => 'Guide Type',
                ],
            ],

            // ── Accommodations ──
            'accommodations' => [
                'label' => 'Accommodations',
                'entities' => [
                    'Accommodation' => 'Accommodation',
                    'Type' => 'Accommodation Type',
                    'Room' => 'Room',
                    'Season' => 'Season',
                    'Meal' => 'Meal',
                    'Supplement' => 'Supplement',
                ],
            ],

            // ── Restaurants ──
            'restaurants' => [
                'label' => 'Restaurants',
                'entities' => [
                    'Restaurant' => 'Restaurant',
                ],
            ],

            // ── Tourist Sites & Services ──
            'tourists' => [
                'label' => 'Tourist Sites & Services',
                'entities' => [
                    'TouristSite' => 'Tourist Site',
                    'TouristService' => 'Tourist Service',
                    'Facility' => 'Facility',
                ],
            ],

            // ── Transportation ──
            'transportation' => [
                'label' => 'Transportation',
                'entities' => [
                    'Company' => 'Company',
                    'Jeep' => 'Jeep / Vehicle',
                    'VehicleType' => 'Vehicle Type',
                    'Route' => 'Route',
                    'Pricing' => 'Pricing',
                ],
            ],

            // ── Entry Points ──
            'entry_points' => [
                'label' => 'Entry Points',
                'entities' => [
                    'Airport' => 'Airport',
                    'Seaport' => 'Seaport',
                    'Landcrossing' => 'Land Crossing',
                ],
            ],

            // ── Travel Documents ──
            'travel_documents' => [
                'label' => 'Travel Documents',
                'entities' => [
                    'TravelPasse' => 'Travel Pass',
                    'VisaRequirement' => 'Visa Requirement',
                    'TravelPassSite' => 'Travel Pass Site',
                ],
            ],

            // ── CRM ──
            'crm' => [
                'label' => 'CRM',
                'entities' => [
                    'Client' => 'Client',
                ],
            ],
        ];
    }

    /**
     * Get available field types.
     */
    public static function getFieldTypes(): array
    {
        return [
            'text' => 'Text',
            'number' => 'Number',
            'email' => 'Email',
            'tel' => 'Phone',
            'url' => 'URL',
            'date' => 'Date',
            'time' => 'Time',
            'datetime-local' => 'Date & Time',
            'textarea' => 'Text Area',
            'select' => 'Dropdown (Select)',
            'multiselect' => 'Multi-Select',
            'radio' => 'Radio Buttons',
            'checkbox' => 'Checkbox',
            'color' => 'Color Picker',
            'range' => 'Range / Slider',
            'file' => 'File Upload',
            'hidden' => 'Hidden Field',
        ];
    }

    /**
     * Flat list of all modules for filters.
     */
    public static function getModules(): array
    {
        $modules = [];
        foreach (static::getModuleRegistry() as $key => $data) {
            $modules[$key] = $data['label'];
        }
        return $modules;
    }

    /**
     * Get entity full class name from short name.
     */
    public static function getEntityClass(string $moduleName, string $entityType): ?string
    {
        $map = [
            'core' => [
                'User' => \App\Models\User::class,
                'PricingDefinition' => \Modules\Core\Entities\PricingDefinition::class,
                'Setting' => \Modules\Core\Entities\Setting::class,
            ],
            'geography' => [
                'Country' => \Modules\Geography\Entities\Country::class,
                'State' => \Modules\Geography\Entities\State::class,
                'City' => \Modules\Geography\Entities\City::class,
                'Region' => \Modules\Geography\Entities\Region::class,
                'Subregion' => \Modules\Geography\Entities\Subregion::class,
                'Nationality' => \Modules\Geography\Entities\Nationality::class,
            ],
            'localization' => [
                'Currency' => \Modules\Localization\Entities\Currency::class,
                'Language' => \Modules\Localization\Entities\Language::class,
                'Timezone' => \Modules\Localization\Entities\Timezone::class,
            ],
            'tour_guides' => [
                'TourGuide' => \Modules\TourGuides\Entities\TourGuide::class,
                'TourGuideType' => \Modules\TourGuides\Entities\TourGuideType::class,
            ],
            'accommodations' => [
                'Accommodation' => \Modules\Accommodations\Entities\Accommodation::class,
                'Type' => \Modules\Accommodations\Entities\Type::class,
                'Room' => \Modules\Accommodations\Entities\Room::class,
                'Season' => \Modules\Accommodations\Entities\Season::class,
                'Meal' => \Modules\Accommodations\Entities\Meal::class,
                'Supplement' => \Modules\Accommodations\Entities\Supplement::class,
            ],
            'restaurants' => [
                'Restaurant' => \Modules\Restaurants\Entities\Restaurant::class,
            ],
            'tourists' => [
                'TouristSite' => \Modules\TouristSites\Entities\TouristSite::class,
                'TouristService' => \Modules\TouristServices\Entities\TouristService::class,
                'Facility' => \Modules\TouristSites\Entities\Facility::class,
            ],
            'transportation' => [
                'Company' => \Modules\Transportation\Entities\Company::class,
                'Jeep' => \Modules\Transportation\Entities\Jeep::class,
                'VehicleType' => \Modules\Transportation\Entities\VehicleType::class,
                'Route' => \Modules\Transportation\Entities\Route::class,
                'Pricing' => \Modules\Transportation\Entities\Pricing::class,
            ],
            'entry_points' => [
                'Airport' => \Modules\EntryPoints\Entities\Airport::class,
                'Seaport' => \Modules\EntryPoints\Entities\Seaport::class,
                'Landcrossing' => \Modules\EntryPoints\Entities\Landcrossing::class,
            ],
            'travel_documents' => [
                'TravelPasse' => \Modules\TravelDocuments\Entities\TravelPasse::class,
                'VisaRequirement' => \Modules\TravelDocuments\Entities\VisaRequirement::class,
                'TravelPassSite' => \Modules\TravelDocuments\Entities\TravelPassSite::class,
            ],
            'crm' => [
                'Client' => \Modules\CRM\Entities\Client::class,
            ],
        ];

        return $map[$moduleName][$entityType] ?? null;
    }
}
