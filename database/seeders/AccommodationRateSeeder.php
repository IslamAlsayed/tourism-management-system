<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccommodationRateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('accommodation_rates')->insert([
            [
                'accommodation_id' => 1,
                'season_id'        => 1,
                'room_type_id'     => 1,
                'price'            => 100.00,
            ],
            [
                'accommodation_id' => 2,
                'season_id'        => 3,
                'room_type_id'     => 2,
                'price'            => 80.00,
            ],
        ]);
    }
}
