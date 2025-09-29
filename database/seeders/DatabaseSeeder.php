<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Subregion;
use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // Currency::truncate();
        // Country::truncate();
        // State::truncate();
        // City::truncate();
        // Region::truncate();
        // Subregion::truncate();
        // Nationality::truncate();
        // Schema::enableForeignKeyConstraints();

        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            LanguageSeeder::class,
        ]);

        // $this->call([
        // LanguageSeeder::class,

        //     SupplierSeeder::class,

        //     TransportationCompanySeeder::class,
        //     TransportationRouteSeeder::class,
        //     BusTypeSeeder::class,
        //     TransportationRateSeeder::class,

        //     AccommodationSeeder::class,
        //     AccommodationSeasonSeeder::class,
        //     HotelSeeder::class,
        //     HotelRoomTypeSeeder::class,
        //     HotelSeasonSeeder::class,

        //     AccommodationRateSeeder::class,
        //     AccommodationRateNationalitySeeder::class,
        //     HotelRateSeeder::class,

        //     AccommodationSupplementSeeder::class,
        //     HotelSupplementSeeder::class,
        //     HotelPolicySeeder::class,

        //     OtherServiceSeeder::class,
        //     SiteSeeder::class,
        // ]);
    }
}