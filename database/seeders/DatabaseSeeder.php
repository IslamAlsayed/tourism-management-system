<?php

namespace Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        truncateWithReset(RichText::class);

        $this->call([
            // RolePermissionSeeder::class,
            // SettingSeeder::class,
            // UserSeeder::class,
            // SystemLanguageSeeder::class,
            // LanguageSeeder::class,
            // TimezoneSeeder::class,
            // CurrencySeeder::class,
            MediaFileSeeder::class, // Must be last to store all existing photos
            // TouristSiteSeeder::class,
            // TouristServiceSeeder::class,
            // EntryPointSeeder::class,
            // AirlineSeeder::class,
            // CompleteDataSeeder::class,
            // AccommodationSeeder::class,
            // RestaurantSeeder::class,
            // TourGuideLanguageSeeder::class,
            // ClientSeeder::class,
            // TransportationCompanySeeder::class,
            // TransportationRouteSeeder::class,
        ]);
    }
}
