<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Schema;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        Country::insert([
            [
                'name' => 'Jordan',
                'name_ar' => 'الأردن',
                'iso2' => 'JO',
                'iso3' => 'JOR',
                'numeric_code' => 400,
                'phone_code' => '962',
                'capital' => 'Amman',
                'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? 1,
                'tld' => '.jo',
                'native' => 'الأردن',
                'region' => 'Asia',
                'region_id' => \App\Models\Region::inRandomOrder()->first()?->id ?? 1,
                'subregion' => 'Western Asia',
                'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id ?? null,
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
                'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? 1,
                'tld' => '.eg',
                'native' => 'مصر',
                'region' => 'Africa',
                'region_id' => \App\Models\Region::inRandomOrder()->first()?->id ?? 1,
                'subregion' => 'Northern Africa',
                'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id ?? null,
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
            ],
        ]);
    }
}