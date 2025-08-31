<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CurrencySeeder::class,
            RegionSeeder::class,
            CountrySeeder::class,
            AccommodationSeeder::class,
            HotelSeeder::class,
            AccommodationSeasonSeeder::class,
            AccommodationRateSeeder::class,
            AccommodationRateNationalitySeeder::class,
            AccommodationSupplementSeeder::class,
            BusTypeSeeder::class,
            HotelPolicySeeder::class,
            HotelRateSeeder::class,
            HotelRoomTypeSeeder::class,
            HotelSeasonSeeder::class,
            HotelSupplementSeeder::class,
            OtherServiceSeeder::class,
            RouteSeeder::class,
            SiteSeeder::class,
            TransportationCompanySeeder::class,
            TransportationRateSeeder::class,
        ]);

        // إذا أردت إعادة تعيين المستخدمين أزل التعليق عن الكود التالي:
        /*
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '12345678'
        ]);
        */
    }
}
