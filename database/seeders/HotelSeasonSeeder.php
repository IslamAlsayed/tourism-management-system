<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeasonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hotel_seasons')->insert([
            [
                'accommodation_id' => 1,    // مصحح: accommodation_id بدلاً من hotel_id
                'season_name' => 'High Season',     // مصحح: season_name بدلاً من name
                'start_date' => '2025-06-01',
                'end_date' => '2025-08-31',
            ],
            [
                'accommodation_id' => 1,    // مصحح
                'season_name' => 'Low Season',      // مصحح
                'start_date' => '2025-09-01',
                'end_date' => '2025-10-31',
            ],
            [
                'accommodation_id' => 2,    // مصحح
                'season_name' => 'Special',         // مصحح
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-31',
            ],
        ]);
    }
}
