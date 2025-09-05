<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingRoomType;
use App\Models\BookingSupplier;
use Illuminate\Database\Seeder;
use App\Models\BookingItinerary;
use App\Models\BookingOtherService;
use Illuminate\Support\Facades\Schema;
use App\Models\BookingTransportationCompany;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // Booking::truncate();
        // BookingRoomType::truncate();
        // BookingItinerary::truncate();
        // BookingTransportationCompany::truncate();
        // BookingOtherService::truncate();
        // BookingSupplier::truncate();
        // Schema::enableForeignKeyConstraints();

        $this->call([
                // 1. Basic system data
            UserSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,

                // 2. Geographical data (regions before countries)
            RegionSeeder::class,
            CountrySeeder::class,
            NationalitySeeder::class,
            SubregionSeeder::class,

            CitySeeder::class,
            StatesSeeder::class,
            SupplierSeeder::class,

                // 3. Transportation (company before bus types before rates)
            TransportationCompanySeeder::class,
            TransportationRouteSeeder::class,
            BusTypeSeeder::class,
            TransportationRateSeeder::class,

                // 4. Accommodation basic data
            AccommodationSeeder::class,
            AccommodationSeasonSeeder::class,
            HotelSeeder::class,
            HotelRoomTypeSeeder::class,
            HotelSeasonSeeder::class,

                // 5. Hotel seasons before rates

                // 6. Rates and policies (after basic data is seeded)
            AccommodationRateSeeder::class,
            AccommodationRateNationalitySeeder::class,
            HotelRateSeeder::class,

                // 7. Supplements and additional services
            AccommodationSupplementSeeder::class,
            HotelSupplementSeeder::class,
            HotelPolicySeeder::class,

                // 8. Other services and locations
            OtherServiceSeeder::class,
            SiteSeeder::class,
        ]);
    }
}