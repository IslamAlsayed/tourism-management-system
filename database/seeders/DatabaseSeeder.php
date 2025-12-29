<?php

namespace Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        RichText::truncate();
        Schema::enableForeignKeyConstraints();

        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            SystemLanguageSeeder::class,
            LanguageSeeder::class,
            TimezoneSeeder::class,
            CurrencySeeder::class,
            TouristSiteSeeder::class,
            CrossingPortSeeder::class,
            AirlineSeeder::class,
            CompleteDataSeeder::class,
            MediaFileSeeder::class, // Must be last to store all existing photos
            AccommodationSeeder::class,
            RestaurantSeeder::class,
            TourGuideLanguageSeeder::class,
            ClientSeeder::class,
        ]);
    }
}