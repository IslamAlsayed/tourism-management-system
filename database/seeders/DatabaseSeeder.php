<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // الماستر/المرجعية أولاً
            LanguageSeeder::class,
            CurrencySeeder::class,
            RegionSeeder::class,
            CountrySeeder::class,
            NationalitySeeder::class,

            // شركات النقل قبل أنواع الحافلات
            TransportationCompanySeeder::class,
            BusTypeSeeder::class,
            TransportationRateSeeder::class,

            // accommodations والفنادق
            AccommodationSeeder::class,
            HotelSeeder::class,
            AccommodationSeasonSeeder::class,

            // *** الأهم هنا: HotelRoomTypeSeeder يجب أن يكون قبل AccommodationRateSeeder ***
            HotelRoomTypeSeeder::class,

            AccommodationRateSeeder::class,
            AccommodationRateNationalitySeeder::class,
            AccommodationSupplementSeeder::class,

            HotelPolicySeeder::class,

            // ضع HotelSeasonSeeder هنا قبل HotelRateSeeder
            HotelSeasonSeeder::class,
            HotelRateSeeder::class,

            HotelSupplementSeeder::class,
            OtherServiceSeeder::class,
            RouteSeeder::class,
            SiteSeeder::class,
        ]);

        // إذا أردت إعادة تعيين المستخدمين أزل التعليق عن الكود التالي:

        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '12345678'
        ]);
    }
}
