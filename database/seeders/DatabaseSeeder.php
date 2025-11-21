<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            SystemLanguageSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            ClientSeeder::class,
            TouristSiteSeeder::class,
            CrossingPortSeeder::class,
            AirlineSeeder::class,
            CompleteDataSeeder::class,
            MediaFileSeeder::class, // Must be last to store all existing photos
        ]);
    }
}