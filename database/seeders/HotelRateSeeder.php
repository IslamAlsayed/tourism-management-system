<?php

namespace Database\Seeders;

use App\Models\HotelRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HotelRateSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HotelRate::truncate();
        Schema::enableForeignKeyConstraints();

        HotelRate::insert([
            [
                'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'hotel_season_id' => \App\Models\HotelSeason::inRandomOrder()->first()?->id ?? 1,
                'room_type_id' => \App\Models\HotelRoomType::inRandomOrder()->first()?->id ?? 1,
                'meal_plan' => 'BB',
                'rate_per_person' => 55.00,
                'single_supplement' => 20.00,
            ],
            [
                'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'hotel_season_id' => \App\Models\HotelSeason::inRandomOrder()->first()?->id ?? 1,
                'room_type_id' => \App\Models\HotelRoomType::inRandomOrder()->first()?->id ?? 1,
                'meal_plan' => 'BB',
                'rate_per_person' => 75.00,
                'single_supplement' => 25.00,
            ],
            [
                'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'hotel_season_id' => \App\Models\HotelSeason::inRandomOrder()->first()?->id ?? 1,
                'room_type_id' => \App\Models\HotelRoomType::inRandomOrder()->first()?->id ?? 1,
                'meal_plan' => 'BB',
                'rate_per_person' => 40.00,
                'single_supplement' => 15.00,
            ],
        ]);
    }
}