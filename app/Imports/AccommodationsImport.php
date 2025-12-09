<?php

namespace App\Imports;

use App\Models\Accommodation;
use App\Models\AccommodationType;
use App\Models\AccommodationMealRate;
use App\Models\AccommodationNationalityRate;
use App\Models\AccommodationRoomRate;
use App\Models\City;
use App\Models\Country;
use App\Models\MealType;
use App\Models\Nationality;
use App\Models\Region;
use App\Models\RoomType;
use App\Models\Season;
use App\Models\State;
use App\Models\Subregion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccommodationsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->processRow($row);
        }
    }

    /**
     * Process a single row from Excel
     */
    protected function processRow($row)
    {
        try {
            // 1. Get or Create Accommodation Type - استخدام العمود الصحيح
            $accommodationType = $this->getOrCreateAccommodationType($row['type'] ?? null);

            // 2. Get or Create Season
            $season = $this->getOrCreateSeason(
                $row['season_from'] ?? null,
                $row['season_to'] ?? null
            );

            // 3. Get Location IDs - استخدام البيانات الموجودة
            $locationData = $this->getLocationData($row);

            // 4. Get or Update Accommodation
            $accommodation = $this->getOrCreateAccommodation($row, $accommodationType, $locationData);

            // 5. Attach Season to Accommodation
            if ($season) {
                $accommodation->seasons()->syncWithoutDetaching([
                    $season->id => [
                        'notes' => $row['note'] ?? null
                    ]
                ]);
            }

            // 6. Process Room Rates
            $this->processRoomRates($row, $accommodation, $season);

            // 7. Process Meal Rates
            $this->processMealRates($row, $accommodation, $season);

            // 8. Process Nationality Rates
            $this->processNationalityRates($row, $accommodation, $season);

        } catch (\Exception $e) {
            Log::error('Error processing accommodation row: ' . $e->getMessage(), [
                'row' => $row->toArray()
            ]);
            // يمكن إضافة معالجة أخرى للخطأ هنا
        }
    }

    /**
     * Get or create accommodation type
     */
    protected function getOrCreateAccommodationType($type)
    {
        if (!$type) {
            return null;
        }

        return AccommodationType::firstOrCreate(
            ['name' => $type],
            [
                'name_ar' => $type, // يمكن تحسينها بترجمة تلقائية
                'is_active' => true
            ]
        );
    }

    /**
     * Get or create season
     */
    protected function getOrCreateSeason($seasonFrom, $seasonTo)
    {
        if (!$seasonFrom || !$seasonTo) {
            return null;
        }

        $from = Carbon::parse($seasonFrom);
        $to = Carbon::parse($seasonTo);

        // Generate season name based on dates
        $seasonName = $from->format('M Y') . ' - ' . $to->format('M Y');

        return Season::firstOrCreate(
            [
                'season_from' => $from,
                'season_to' => $to
            ],
            [
                'name' => $seasonName,
                'name_ar' => $seasonName,
                'is_active' => true
            ]
        );
    }

    /**
     * Get location data from row
     */
    protected function getLocationData($row)
    {
        return [
            'region_id' => $row['region_id'] ?? null,
            'subregion_id' => $row['subregion_id'] ?? null,
            'country_id' => $row['country_id'] ?? null,
            'state_id' => $row['state_id'] ?? null,
            'city_id' => $row['city_id'] ?? null,
        ];
    }

    /**
     * Get or create accommodation
     */
    protected function getOrCreateAccommodation($row, $accommodationType, $locationData = [])
    {
        $data = [
            'name' => $row['name'] ?? 'Unknown',
            'name_ar' => $row['name_ar'] ?? $row['name'] ?? 'Unknown',
            'classification' => $row['classification'] ?? null,
            'description' => $row['description'] ?? null,
            'accommodation_type_id' => $accommodationType?->id,
            'region_id' => $locationData['region_id'] ?? $row['region_id'] ?? null,
            'subregion_id' => $locationData['subregion_id'] ?? $row['subregion_id'] ?? null,
            'country_id' => $locationData['country_id'] ?? $row['country_id'] ?? null,
            'state_id' => $locationData['state_id'] ?? $row['state_id'] ?? null,
            'city_id' => $locationData['city_id'] ?? $row['city_id'] ?? null,
            'default_currency' => $row['currency'] ?? 'USD',
            'is_active' => true
        ];

        return Accommodation::updateOrCreate(
            ['name' => $row['name'] ?? 'Unknown'],
            $data
        );
    }

    /**
     * Process room rates
     */
    protected function processRoomRates($row, $accommodation, $season)
    {
        if (!$season) {
            return;
        }

        // Get room type
        $roomType = $this->getOrCreateRoomType($row['room_type'] ?? 'Standard');

        // Create or update room rate - استخدام الأسماء الصحيحة للأعمدة
        AccommodationRoomRate::updateOrCreate(
            [
                'accommodation_id' => $accommodation->id,
                'season_id' => $season->id,
                'room_type_id' => $roomType->id
            ],
            [
                'price_per_person_double' => $row['p_p_double_room'] ?? $row['ppdouble_room'] ?? null,
                'single_room_supplement' => $row['single_room_supp'] ?? null,
                'triple_room_discount' => $row['triple_room'] ?? null,
                'third_person_price' => $row['3rd_person'] ?? null,
                'extra_bed_price' => $row['extra_bed'] ?? null,
                'sea_view_supplement' => $row['sea_view_room_supp'] ?? null,
                'currency' => $row['currency'] ?? 'USD',
                'notes' => $row['note'] ?? null
            ]
        );
    }

    /**
     * Process meal rates
     */
    protected function processMealRates($row, $accommodation, $season)
    {
        if (!$season) {
            return;
        }

        $meals = [
            'breakfast_meal' => 'Breakfast',
            'lunch_meal_supp' => 'Lunch',
            'dinner_meal' => 'Dinner',
            'extra_meal' => 'Extra Meal'
        ];

        foreach ($meals as $columnKey => $mealName) {
            $price = $row[$columnKey] ?? null;

            if ($price && $price > 0) {
                $mealType = $this->getOrCreateMealType($mealName);

                AccommodationMealRate::updateOrCreate(
                    [
                        'accommodation_id' => $accommodation->id,
                        'season_id' => $season->id,
                        'meal_type_id' => $mealType->id
                    ],
                    [
                        'price' => $price,
                        'currency' => $row['currency'] ?? 'USD',
                        'is_supplement' => true,
                        'notes' => null
                    ]
                );
            }
        }
    }

    /**
     * Process nationality rates
     */
    protected function processNationalityRates($row, $accommodation, $season)
    {
        if (!$season) {
            return;
        }

        $nationalitiesData = $row['nationalities_rates'] ?? null;

        // إذا كانت القيمة "All" فهذا يعني أن الأسعار تطبق على جميع الجنسيات
        if ($nationalitiesData === 'All' || empty($nationalitiesData)) {
            // يمكن تخطي هذا أو إنشاء سجل افتراضي
            return;
        }

        // معالجة البيانات المنسقة كـ "nationality_id:modifier,nationality_id:modifier"
        // مثال: "1:10,2:-5,3:0"
        if (is_string($nationalitiesData) && $nationalitiesData !== 'All') {
            $pairs = explode(',', $nationalitiesData);

            foreach ($pairs as $pair) {
                $parts = explode(':', trim($pair));

                if (count($parts) >= 2) {
                    $nationalityId = trim($parts[0]);
                    $modifier = trim($parts[1]);

                    // التأكد من أن nationality_id رقم صحيح
                    if (is_numeric($nationalityId)) {
                        AccommodationNationalityRate::updateOrCreate(
                            [
                                'accommodation_id' => $accommodation->id,
                                'season_id' => $season->id,
                                'nationality_id' => $nationalityId
                            ],
                            [
                                'price_modifier' => $modifier,
                                'currency' => $row['currency'] ?? 'USD',
                                'notes' => null
                            ]
                        );
                    }
                }
            }
        }
    }

    /**
     * Get or create room type
     */
    protected function getOrCreateRoomType($type)
    {
        return RoomType::firstOrCreate(
            ['name' => $type],
            [
                'name_ar' => $type,
                'max_occupancy' => $this->getMaxOccupancy($type),
                'is_active' => true
            ]
        );
    }

    /**
     * Get or create meal type
     */
    protected function getOrCreateMealType($type)
    {
        return MealType::firstOrCreate(
            ['name' => $type],
            [
                'name_ar' => $this->translateMealType($type),
                'is_included' => false,
                'is_active' => true
            ]
        );
    }

    /**
     * Get max occupancy based on room type name
     */
    protected function getMaxOccupancy($roomType)
    {
        $type = strtolower($roomType);

        if (str_contains($type, 'single'))
            return 1;
        if (str_contains($type, 'double'))
            return 2;
        if (str_contains($type, 'triple'))
            return 3;
        if (str_contains($type, 'quad'))
            return 4;
        if (str_contains($type, 'suite'))
            return 4;

        return 2; // default
    }

    /**
     * Translate meal type to Arabic
     */
    protected function translateMealType($mealType)
    {
        $translations = [
            'Breakfast' => 'إفطار',
            'Lunch' => 'غداء',
            'Dinner' => 'عشاء',
            'Extra Meal' => 'وجبة إضافية',
            'Full Board' => 'إقامة كاملة',
            'Half Board' => 'نصف إقامة'
        ];

        return $translations[$mealType] ?? $mealType;
    }
}

// accommodation_id	region_id	regions	subregion_id	subregions	country_id	countries	city_id	cities	nationalities_rates	currency	city	type	accommodation_type_id	classification	name	name_ar	type	season_from	season_to	room_type	p.p.double_room	p.p.double_room	single_room_supp	triple_room	3rd person	breakfast_meal	lunch_meal_supp	dinner_meal	extra_bed	extra_meal	sea_view_room_supp	note	
// 1	3	Asia	23	Middle East	111	Jordan	63142	Wadi Rum	All	USD	Wadi Rum	camp	12	3*	CAPTAIN’S MAIN CAMP	CAPTAIN’S MAIN CAMP	camp	Wednesday, January 1, 2025	Monday, December 29, 2025	Bedouin Tent, H.B	28.00	56.00	15.00	84.00	28.00		8.00	8.00	28.00	8.00			
// 2	3	Asia	23	Middle East	111	Jordan	63142	Wadi Rum	All	USD	Wadi Rum	camp	12	3*	CAPTAIN’S MAIN CAMP	CAPTAIN’S MAIN CAMP	camp	Wednesday, January 1, 2025	Monday, December 29, 2025	Deluxe room Tent, WC, H.B	35.00	70.00	20.00	105.00	35.00		10.00	10.00	35.00	10.00			