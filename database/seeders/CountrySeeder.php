<?php

namespace Database\Seeders;

use Schema;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Subregion;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        $countries = [
            ['name' => 'Egypt', 'subregion_id' => 1, 'currency_id' => 1],
            ['name' => 'Saudi Arabia', 'subregion_id' => 3, 'currency_id' => 2],
            ['name' => 'United Arab Emirates', 'subregion_id' => 3, 'currency_id' => 3],
            ['name' => 'Jordan', 'subregion_id' => 4, 'currency_id' => 4],
            ['name' => 'Lebanon', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Palestine', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Syria', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Iraq', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Libya', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Tunisia', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Morocco', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Mauritania', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Oman', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Kuwait', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Bahrain', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Yemen', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Sudan', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Somalia', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Qatar', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Djibouti', 'subregion_id' => 1, 'currency_id' => 5],
            ['name' => 'Comoros', 'subregion_id' => 1, 'currency_id' => 5],
        ];





























        $countries = [
            [
                'name' => 'Jordan',
                'name_ar' => 'الأردن',
                'iso2' => 'JO',
                'iso3' => 'JOR',
                'numeric_code' => 400,
                'phone_code' => '962',
                'capital' => 'Amman',
                'currency_id' => Currency::inRandomOrder()->first()?->id ?? 1,
                'tld' => '.jo',
                'native' => 'الأردن',
                'region' => 'Asia',
                'region_id' => Region::inRandomOrder()->first()?->id ?? 1,
                'subregion' => 'Western Asia',
                'subregion_id' => Subregion::inRandomOrder()->first()?->id ?? null,
                'nationality' => 'Jordanian',
                'timezone' => 'Asia/Amman',
                'latitude' => 31.963158,
                'longitude' => 35.930359,
                'emoji' => '🇯🇴',
                'emojiU' => null,
                'population' => 10000000,
                'flag_url' => null,
                'flag_emoji' => null,
                'continent' => 'Asia',
                'area' => 89342,
                'is_active' => true,
            ],
            [
                'name' => 'Egypt',
                'name_ar' => 'مصر',
                'iso2' => 'EG',
                'iso3' => 'EGY',
                'numeric_code' => 818,
                'phone_code' => '20',
                'capital' => 'Cairo',
                'currency_id' => Currency::inRandomOrder()->first()?->id ?? 1,
                'tld' => '.eg',
                'native' => 'مصر',
                'region' => 'Africa',
                'region_id' => Region::inRandomOrder()->first()?->id ?? 1,
                'subregion' => 'Northern Africa',
                'subregion_id' => Subregion::inRandomOrder()->first()?->id ?? null,
                'nationality' => 'Egyptian',
                'timezone' => 'Africa/Cairo',
                'latitude' => 26.820553,
                'longitude' => 30.802498,
                'emoji' => '🇪🇬',
                'emojiU' => null,
                'population' => 100000000,
                'flag_url' => null,
                'flag_emoji' => null,
                'continent' => 'Africa',
                'area' => 1002450,
                'is_active' => true,
            ]
        ];

        Country::insert($countries);
    }
}