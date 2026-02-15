<?php

namespace Modules\Geography\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Accommodations\Entities\Type;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\Nationality;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Subregion;
use Modules\Localization\Entities\Timezone;
use Modules\Restaurants\Entities\Restaurant;
use Modules\TourGuides\Entities\TourGuide;
use Modules\TourGuides\Entities\TourGuideReview;
use Modules\TourGuides\Entities\TourGuideType;

class CompleteDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * PhotoObserver will automatically create MediaFile records for all photos.
     */
    public function run(): void
    {
        truncateWithReset(Nationality::class);
        RichText::where('record_type', Nationality::class)->delete();

        truncateWithReset(City::class);
        RichText::where('record_type', City::class)->delete();

        truncateWithReset(State::class);
        RichText::where('record_type', State::class)->delete();

        truncateWithReset(Country::class);
        RichText::where('record_type', Country::class)->delete();

        truncateWithReset(Restaurant::class);
        RichText::where('record_type', Restaurant::class)->delete();

        truncateWithReset(TourGuideType::class);
        RichText::where('record_type', TourGuideType::class)->delete();

        truncateWithReset(TourGuide::class);
        RichText::where('record_type', TourGuide::class)->delete();

        truncateWithReset(Type::class);
        RichText::where('record_type', Type::class)->delete();

        // Types
        $types = [
            ['name' => 'Hotel', 'name_ar' => 'فندق'],
            ['name' => 'Restaurant', 'name_ar' => 'مطعم'],
        ];
        foreach ($types as $typeData) {
            Type::create($typeData);
        }

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
            ['name' => 'Cairo', 'name_ar' => 'القاهرة', 'iso2' => 'C', 'country_id' => $createdCountries[0]->id],
            ['name' => 'Giza', 'name_ar' => 'الجيزة', 'iso2' => 'GZ', 'country_id' => $createdCountries[0]->id],
            ['name' => 'Amman', 'name_ar' => 'عمان', 'iso2' => 'AM', 'country_id' => $createdCountries[1]->id],
            ['name' => 'Aqaba', 'name_ar' => 'العقبة', 'iso2' => 'AQ', 'country_id' => $createdCountries[1]->id],
        ];
        $createdStates = [];
        foreach ($states as $stateData) {
            $createdStates[] = State::create($stateData);
        }

        // Cities
        $cities = [
            // Cairo State Cities
            ['name' => 'Nasr City', 'name_ar' => 'مدينة نصر', 'state_id' => $createdStates[0]->id, 'population' => 2500000, 'latitude' => 30.0444, 'longitude' => 31.3547],
            ['name' => 'Heliopolis', 'name_ar' => 'مصر الجديدة', 'state_id' => $createdStates[0]->id, 'population' => 1800000, 'latitude' => 30.0880, 'longitude' => 31.3220],
            ['name' => 'Maadi', 'name_ar' => 'المعادي', 'state_id' => $createdStates[0]->id, 'population' => 750000, 'latitude' => 29.9602, 'longitude' => 31.2569],
            // Giza State Cities
            ['name' => '6th of October', 'name_ar' => '6 أكتوبر', 'state_id' => $createdStates[1]->id, 'population' => 650000, 'latitude' => 29.9334, 'longitude' => 30.9166],
            ['name' => 'Dokki', 'name_ar' => 'الدقي', 'state_id' => $createdStates[1]->id, 'population' => 500000, 'latitude' => 30.0385, 'longitude' => 31.2121],
            ['name' => 'Haram', 'name_ar' => 'الهرم', 'state_id' => $createdStates[1]->id, 'population' => 850000, 'latitude' => 29.9897, 'longitude' => 31.1689],
            // Amman State Cities
            ['name' => 'Abdali', 'name_ar' => 'العبدلي', 'state_id' => $createdStates[2]->id, 'population' => 450000, 'latitude' => 31.9632, 'longitude' => 35.9104],
            ['name' => 'Jabal Amman', 'name_ar' => 'جبل عمان', 'state_id' => $createdStates[2]->id, 'population' => 380000, 'latitude' => 31.9539, 'longitude' => 35.9106],
            ['name' => 'Zarqa', 'name_ar' => 'الزرقاء', 'state_id' => $createdStates[2]->id, 'population' => 635160, 'latitude' => 32.0727, 'longitude' => 36.0880],
            // Aqaba State Cities
            ['name' => 'Aqaba City', 'name_ar' => 'مدينة العقبة', 'state_id' => $createdStates[3]->id, 'population' => 120000, 'latitude' => 29.5320, 'longitude' => 35.0063],
            ['name' => 'Wadi Rum', 'name_ar' => 'وادي رم', 'state_id' => $createdStates[3]->id, 'population' => 15000, 'latitude' => 29.5756, 'longitude' => 35.4164],
            // Additional requested cities
            ['name' => 'Cairo', 'name_ar' => 'القاهرة', 'state_id' => $createdStates[0]->id, 'population' => 9500000, 'latitude' => 30.0444, 'longitude' => 31.2357],
            ['name' => 'Alexandria', 'name_ar' => 'الإسكندرية', 'state_id' => $createdStates[0]->id, 'population' => 5200000, 'latitude' => 31.2001, 'longitude' => 29.9187],
            ['name' => 'Luxor', 'name_ar' => 'الأقصر', 'state_id' => $createdStates[0]->id, 'population' => 1270000, 'latitude' => 25.6872, 'longitude' => 32.6396],
            ['name' => 'Aswan', 'name_ar' => 'أسوان', 'state_id' => $createdStates[0]->id, 'population' => 1500000, 'latitude' => 24.0889, 'longitude' => 32.8998],
            ['name' => 'Sharm El Sheikh', 'name_ar' => 'شرم الشيخ', 'state_id' => $createdStates[0]->id, 'population' => 73000, 'latitude' => 27.9158, 'longitude' => 34.3299],
            ['name' => 'Hurghada', 'name_ar' => 'الغردقة', 'state_id' => $createdStates[0]->id, 'population' => 261714, 'latitude' => 27.2579, 'longitude' => 33.8116],
            ['name' => 'Amman', 'name_ar' => 'عمان', 'state_id' => $createdStates[2]->id, 'population' => 4000000, 'latitude' => 31.9539, 'longitude' => 35.9106],
            ['name' => 'Petra', 'name_ar' => 'البتراء', 'state_id' => $createdStates[2]->id, 'population' => 26000, 'latitude' => 30.3285, 'longitude' => 35.4444],
            ['name' => 'Aqaba', 'name_ar' => 'العقبة', 'state_id' => $createdStates[3]->id, 'population' => 188160, 'latitude' => 29.5320, 'longitude' => 35.0063],
        ];
        $createdCities = [];
        foreach ($cities as $cityData) {
            $createdCities[] = City::create($cityData);
        }

        // Nationalities
        $nationalities = [
            ['name' => 'Egyptian', 'name_ar' => 'مصري', 'country_id' => $createdCountries[0]->id, 'is_active' => true],
            ['name' => 'Jordanian', 'name_ar' => 'أردني', 'country_id' => $createdCountries[1]->id, 'is_active' => true],
        ];
        $createdNationalities = [];
        foreach ($nationalities as $nationalityData) {
            $createdNationalities[] = Nationality::create($nationalityData);
        }

        // Tour Guide Types
        $tourGuideTypes = [
            [
                'type' => 'Historical Sites Guide',
                'price' => 500,
                'currency_id' => 1,
                'country_id' => $createdCountries[0]->id,
                'all_states' => false,
                'all_cities' => false,
            ],
            [
                'type' => 'Archaeological Guide',
                'price' => 75,
                'currency_id' => 2,
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
        $createdTourGuides = [];
        foreach ($tourGuides as $guideData) {
            $createdTourGuides[] = TourGuide::create($guideData);
        }

        // Tour Guides Reviews
        $tourGuidesReviews = [
            [
                'tour_guide_id' => $createdTourGuides[0]->id,
                'rating' => rand(1, 5),
                'review' => fake()->paragraph(3),
            ],
            [
                'tour_guide_id' => $createdTourGuides[1]->id,
                'rating' => rand(1, 5),
                'review' => fake()->paragraph(3),
            ],
        ];
        foreach ($tourGuidesReviews as $guideData) {
            TourGuideReview::create($guideData);
        }
    }
}
