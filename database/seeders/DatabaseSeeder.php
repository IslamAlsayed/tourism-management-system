<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingRoomType;
use App\Models\BookingSupplier;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use App\Models\BookingItinerary;
use App\Models\BookingOtherService;
use Illuminate\Support\Facades\Schema;
use App\Models\BookingTransportationCompany;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,


            // CountrySeeder::class,
            // StatesSeeder::class,
            // CitySeeder::class,
            // RegionSeeder::class,
            // SubregionSeeder::class,
            // NationalitySeeder::class,
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