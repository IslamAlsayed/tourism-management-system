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
            ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
            ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
            ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
            ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
            ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
            ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
            ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
            ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
            ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
            ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
            ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
            ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
            ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
            ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
            ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
            ['name' => 'Ashkāsham', 'name_ar' => 'أشكاشم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.68333, 'longitude' => 71.53333, 'timezone' => null, 'wikidataId' => 'Q4805192', 'population' => null],
            ['name' => 'Fayzabad', 'name_ar' => 'فايز آباد', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.11664, 'longitude' => 70.58002, 'timezone' => null, 'wikidataId' => 'Q156558', 'population' => null],
            ['name' => 'Jurm', 'name_ar' => 'جورم', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.86477, 'longitude' => 70.83421, 'timezone' => null, 'wikidataId' => 'Q10308323', 'population' => null],
            ['name' => 'Khandūd', 'name_ar' => 'خانود', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 36.95127, 'longitude' => 72.318, 'timezone' => null, 'wikidataId' => 'Q3290334', 'population' => null],
            ['name' => 'Rāghistān', 'name_ar' => 'راخستان', 'state_id' => State::inRandomOrder()->first()?->id ?? 1, 'country_id' => Country::inRandomOrder()->first()?->id ?? 1, 'latitude' => 37.66079, 'longitude' => 70.67346, 'timezone' => null, 'wikidataId' => 'Q2670909', 'population' => null],
        ];

        City::insert($cities);
    }
}