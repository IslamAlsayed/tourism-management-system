<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        City::truncate();
        Schema::enableForeignKeyConstraints();

        $cities = [
            ['name' => 'Cairo', 'name_ar' => 'القاهرة', 'state_id' => State::inRandomOrder()->first()?->id, 'country_id' => Country::where('name', 'Egypt')->first()?->id, 'latitude' => 30.0444, 'longitude' => 31.2357, 'timezone' => 'Africa/Cairo', 'wiki_data_id' => 'Q85', 'population' => 20000000],
            ['name' => 'Riyadh', 'name_ar' => 'الرياض', 'state_id' => State::inRandomOrder()->first()?->id, 'country_id' => Country::where('name', 'Saudi Arabia')->first()?->id, 'latitude' => 24.7136, 'longitude' => 46.6753, 'timezone' => 'Asia/Riyadh', 'wiki_data_id' => 'Q3692', 'population' => 7500000],
            ['name' => 'Dubai', 'name_ar' => 'دبي', 'state_id' => State::inRandomOrder()->first()?->id, 'country_id' => Country::where('name', 'United Arab Emirates')->first()?->id, 'latitude' => 25.276987, 'longitude' => 55.296249, 'timezone' => 'Asia/Dubai', 'wiki_data_id' => 'Q613', 'population' => 3500000],
        ];

        City::insert($cities);

        // $cities = [
        //     ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
        //     ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
        //     ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
        //     ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
        //     ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
        //     ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
        //     ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
        //     ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
        //     ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
        //     ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
        //     ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
        //     ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
        //     ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
        //     ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
        //     ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
        //     ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
        //     ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
        //     ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
        //     ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
        //     ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
        // ];
    }
}