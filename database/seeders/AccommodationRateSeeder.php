<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccommodationRate;
use Illuminate\Support\Facades\Schema;

class AccommodationRateSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AccommodationRate::truncate();
        Schema::enableForeignKeyConstraints();

        AccommodationRate::insert([
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'season_id' => \App\Models\HotelSeason::inRandomOrder()->first()?->id ?? 1,
                'room_type_id' => \App\Models\HotelRoomType::inRandomOrder()->first()?->id ?? 1,
                'price' => 100.00,
            ],
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 2,
                'season_id' => \App\Models\HotelSeason::inRandomOrder()->first()?->id ?? 3,
                'room_type_id' => \App\Models\HotelRoomType::inRandomOrder()->first()?->id ?? 2,
                'price' => 80.00,
            ],
        ]);
    }
}