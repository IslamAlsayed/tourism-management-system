<?php

namespace Database\Seeders;

use ZipStream\Time;
use App\Models\City;
use App\Models\Type;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Timezone;
use App\Models\Subregion;
use App\Models\TourGuide;
use App\Models\Restaurant;
use App\Models\Nationality;
use App\Models\TourGuideType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CompleteDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * PhotoObserver will automatically create MediaFile records for all photos.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        City::truncate();
        Country::truncate();
        Nationality::truncate();
        Region::truncate();
        Restaurant::truncate();
        State::truncate();
        Subregion::truncate();
        TourGuide::truncate();
        TourGuideType::truncate();
        Type::truncate();
        Schema::enableForeignKeyConstraints();

        // ============================================
        // 1. Base Data (No Dependencies)
        // ============================================

        // Types
        $types = [
            ['name' => 'Hotel', 'name_ar' => 'فندق'],
            ['name' => 'Restaurant', 'name_ar' => 'مطعم'],
        ];
        foreach ($types as $typeData) {
            Type::create($typeData);
        }

        // ============================================
        // 2. Geographical Hierarchy
        // ============================================

        // Regions
        $regions = [
            ['name' => 'Middle East', 'name_ar' => 'الشرق الأوسط'],
            ['name' => 'North Africa', 'name_ar' => 'شمال أفريقيا'],
        ];
        $createdRegions = [];
        foreach ($regions as $regionData) {
            $createdRegions[] = Region::create($regionData);
        }

        // Subregions
        $subregions = [
            ['name' => 'Eastern Mediterranean', 'name_ar' => 'شرق البحر المتوسط', 'region_id' => $createdRegions[0]->id],
            ['name' => 'Nile Valley', 'name_ar' => 'وادي النيل', 'region_id' => $createdRegions[1]->id],
        ];
        $createdSubregions = [];
        foreach ($subregions as $subregionData) {
            $createdSubregions[] = Subregion::create($subregionData);
        }

        // Countries
        $countries = [
            [
                'name' => 'Egypt',
                'name_ar' => 'مصر',
                'iso2' => 'EG',
                'iso3' => 'EGY',
                'numeric_code' => '818',
                'phone_code' => '+20',
                'capital' => 'Cairo',
                'language_id' => 1,
                'currency_id' => 1,
                'region_id' => $createdRegions[1]->id,
                'subregion_id' => $createdSubregions[1]->id,
                'population' => 104000000,
                'area' => 1001450,
                'latitude' => 26.8206,
                'longitude' => 30.8025,
                'timezone_id' => Timezone::where('name', 'Africa/Cairo')->first()?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Jordan',
                'name_ar' => 'الأردن',
                'iso2' => 'JO',
                'iso3' => 'JOR',
                'numeric_code' => '400',
                'phone_code' => '+962',
                'capital' => 'Amman',
                'language_id' => 1,
                'currency_id' => 2,
                'region_id' => $createdRegions[0]->id,
                'subregion_id' => $createdSubregions[0]->id,
                'population' => 10200000,
                'area' => 89342,
                'latitude' => 30.5852,
                'longitude' => 36.2384,
                'timezone_id' => Timezone::where('name', 'Asia/Amman')->first()?->id,
                'is_active' => true,
            ],
        ];
        $createdCountries = [];
        foreach ($countries as $countryData) {
            $createdCountries[] = Country::create($countryData);
        }

        // States
        $states = [
            ['name' => 'Cairo', 'name_ar' => 'القاهرة', 'iso2' => 'C', 'timezone_id' => Timezone::where('name', 'Africa/Cairo')->first()?->id, 'country_id' => $createdCountries[0]->id, 'region_id' => $createdRegions[1]->id, 'subregion_id' => $createdSubregions[1]->id],
            ['name' => 'Giza', 'name_ar' => 'الجيزة', 'iso2' => 'GZ', 'timezone_id' => Timezone::where('name', 'Africa/Cairo')->first()?->id, 'country_id' => $createdCountries[0]->id, 'region_id' => $createdRegions[1]->id, 'subregion_id' => $createdSubregions[1]->id],
            ['name' => 'Amman', 'name_ar' => 'عمان', 'iso2' => 'AM', 'timezone_id' => Timezone::where('name', 'Asia/Amman')->first()?->id, 'country_id' => $createdCountries[1]->id, 'region_id' => $createdRegions[0]->id, 'subregion_id' => $createdSubregions[0]->id],
            ['name' => 'Aqaba', 'name_ar' => 'العقبة', 'iso2' => 'AQ', 'timezone_id' => Timezone::where('name', 'Asia/Amman')->first()?->id, 'country_id' => $createdCountries[1]->id, 'region_id' => $createdRegions[0]->id, 'subregion_id' => $createdSubregions[0]->id],
        ];
        $createdStates = [];
        foreach ($states as $stateData) {
            $createdStates[] = State::create($stateData);
        }

        // Cities
        $cities = [
            ['name' => 'Cairo', 'name_ar' => 'القاهرة', 'timezone_id' => Timezone::where('name', 'Africa/Cairo')->first()?->id, 'country_id' => $createdCountries[0]->id, 'state_id' => $createdStates[0]->id, 'region_id' => $createdRegions[1]->id, 'subregion_id' => $createdSubregions[1]->id, 'population' => 9500000, 'latitude' => 30.0444, 'longitude' => 31.2357],
            ['name' => 'Giza', 'name_ar' => 'الجيزة', 'timezone_id' => Timezone::where('name', 'Africa/Cairo')->first()?->id, 'country_id' => $createdCountries[0]->id, 'state_id' => $createdStates[1]->id, 'region_id' => $createdRegions[1]->id, 'subregion_id' => $createdSubregions[1]->id, 'population' => 4000000, 'latitude' => 30.0131, 'longitude' => 31.2089],
            ['name' => 'Amman', 'name_ar' => 'عمان', 'timezone_id' => Timezone::where('name', 'Asia/Amman')->first()?->id, 'country_id' => $createdCountries[1]->id, 'state_id' => $createdStates[2]->id, 'region_id' => $createdRegions[0]->id, 'subregion_id' => $createdSubregions[0]->id, 'population' => 4000000, 'latitude' => 31.9454, 'longitude' => 35.9284],
            ['name' => 'Aqaba', 'name_ar' => 'العقبة', 'timezone_id' => Timezone::where('name', 'Asia/Amman')->first()?->id, 'country_id' => $createdCountries[1]->id, 'state_id' => $createdStates[3]->id, 'region_id' => $createdRegions[0]->id, 'subregion_id' => $createdSubregions[0]->id, 'population' => 150000, 'latitude' => 29.5320, 'longitude' => 35.0063],
        ];
        $createdCities = [];
        foreach ($cities as $cityData) {
            $createdCities[] = City::create($cityData);
        }

        // ============================================
        // 3. People & Organizations
        // ============================================

        // Nationalities
        $nationalities = [
            ['name' => 'Egyptian', 'name_ar' => 'مصري', 'country_id' => $createdCountries[0]->id, 'region_id' => $createdRegions[1]->id, 'subregion_id' => $createdSubregions[1]->id, 'is_active' => true],
            ['name' => 'Jordanian', 'name_ar' => 'أردني', 'country_id' => $createdCountries[1]->id, 'region_id' => $createdRegions[0]->id, 'subregion_id' => $createdSubregions[0]->id, 'is_active' => true],
        ];
        $createdNationalities = [];
        foreach ($nationalities as $nationalityData) {
            $createdNationalities[] = Nationality::create($nationalityData);
        }

        // Restaurants
        $restaurants = [
            [
                'name' => 'Nile Maxim Restaurant',
                'name_ar' => 'مطعم نايل ماكسيم',
                'specialty' => 'Egyptian Cuisine',
                'phone_01' => '+20-2-25735696',
                'email_01' => 'info@nilemaxim.com',
                'website' => 'https://nilemaxim.com',
                'is_active' => true,
                'rating' => 4.5,
                'type_id' => 2,
                'region_id' => $createdRegions[1]->id,
                'subregion_id' => $createdSubregions[1]->id,
                'country_id' => $createdCountries[0]->id,
                'state_id' => $createdStates[0]->id,
                'city_id' => $createdCities[0]->id,
            ],
            [
                'name' => 'Hashem Restaurant',
                'name_ar' => 'مطعم هاشم',
                'specialty' => 'Traditional Jordanian',
                'phone_01' => '+962-6-4636440',
                'email_01' => 'info@hashemrestaurant.com',
                'is_active' => true,
                'rating' => 4.7,
                'type_id' => 2,
                'region_id' => $createdRegions[0]->id,
                'subregion_id' => $createdSubregions[0]->id,
                'country_id' => $createdCountries[1]->id,
                'state_id' => $createdStates[2]->id,
                'city_id' => $createdCities[2]->id,
            ],
        ];
        foreach ($restaurants as $restaurantData) {
            Restaurant::create($restaurantData);
        }

        // Tour Guide Types
        $tourGuideTypes = [
            [
                'type' => 'Historical Sites Guide',
                'price' => 500,
                'currency_id' => 1,
                'region_id' => $createdRegions[1]->id,
                'subregion_id' => $createdSubregions[1]->id,
                'country_id' => $createdCountries[0]->id,
                'all_states' => false,
                'all_cities' => false,
            ],
            [
                'type' => 'Archaeological Guide',
                'price' => 75,
                'currency_id' => 2,
                'region_id' => $createdRegions[0]->id,
                'subregion_id' => $createdSubregions[0]->id,
                'country_id' => $createdCountries[1]->id,
                'all_states' => false,
                'all_cities' => false,
            ],
        ];
        $createdGuideTypes = [];
        foreach ($tourGuideTypes as $guideTypeData) {
            $createdGuideTypes[] = TourGuideType::create($guideTypeData);
        }

        // Tour Guides
        $tourGuides = [
            [
                'name' => 'Mahmoud Ibrahim',
                'name_ar' => 'محمود إبراهيم',
                'mobile_01' => '+20-1098765432',
                'email' => 'mahmoud@example.com',
                'national_guide_id' => $createdNationalities[0]->id,
                'guide_type_id' => $createdGuideTypes[0]->id,
                'fd_day_fees' => 500,
                'hd_day_fees' => 300,
            ],
            [
                'name' => 'Omar Khalil',
                'name_ar' => 'عمر خليل',
                'mobile_01' => '+962-779876543',
                'email' => 'omar@example.com',
                'national_guide_id' => $createdNationalities[1]->id,
                'guide_type_id' => $createdGuideTypes[1]->id,
                'fd_day_fees' => 75,
                'hd_day_fees' => 45,
            ],
        ];
        foreach ($tourGuides as $guideData) {
            TourGuide::create($guideData);
        }
    }
}