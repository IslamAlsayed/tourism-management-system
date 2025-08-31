<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelRateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hotel_rates')->insert([
            [
                'hotel_season_id' => 1,
                'room_type_id' => 1,
                'meal_plan' => 'BB',
                'rate_per_person' => 55.00,
                'single_supplement' => 20.00,
            ],
            [
                'hotel_season_id' => 2,
                'room_type_id' => 1,
                'meal_plan' => 'BB',
                'rate_per_person' => 75.00,
                'single_supplement' => 25.00,
            ],
            [
                'hotel_season_id' => 3,
                'room_type_id' => 3,
                'meal_plan' => 'BB',
                'rate_per_person' => 40.00,
                'single_supplement' => 15.00,
            ],
        ]);
    }
}
