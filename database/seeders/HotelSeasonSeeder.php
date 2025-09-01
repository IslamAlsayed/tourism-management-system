<?php

namespace Database\Seeders;

use App\Models\HotelSeason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HotelSeasonSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HotelSeason::truncate();
        Schema::enableForeignKeyConstraints();

        HotelSeason::insert([
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,    // مصحح: accommodation_id بدلاً من hotel_id
                'season_name' => 'High Season',     // مصحح: season_name بدلاً من name
                'start_date' => '2025-06-01',
                'end_date' => '2025-08-31',
            ],
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,    // مصحح
                'season_name' => 'Low Season',      // مصحح
                'start_date' => '2025-09-01',
                'end_date' => '2025-10-31',
            ],
            [
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,    // مصحح
                'season_name' => 'Special',         // مصحح
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-31',
            ],
        ]);
    }
}