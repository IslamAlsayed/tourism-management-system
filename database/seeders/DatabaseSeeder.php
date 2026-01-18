<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Room;
use App\Models\Type;
use App\Models\Season;
use App\Models\RichText;
use App\Models\Supplement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        RichText::truncate();
        // Supplement::truncate();
        // Meal::truncate();
        // Room::truncate();
        // Season::truncate();
        // Type::truncate();
        Schema::enableForeignKeyConstraints();

        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            SystemLanguageSeeder::class,
            LanguageSeeder::class,
            TimezoneSeeder::class,
            CurrencySeeder::class,
            MediaFileSeeder::class, // Must be last to store all existing photos
            // TouristSiteSeeder::class,
            // TouristServiceSeeder::class,
            // CrossingPortSeeder::class,
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