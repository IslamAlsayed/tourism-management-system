<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccommodationSeasonSeeder extends Seeder
{
    public function run()
    {
        DB::table('accommodation_seasons')->insert([
            [
                'accommodation_id' => 1,
                'season_name' => 'High Season',
                'start_date' => '2025-06-01',
                'end_date' => '2025-08-31',
                'is_special' => false,
                'special_type' => null,
            ],
            [
                'accommodation_id' => 1,
                'season_name' => 'Eid Holiday',
                'start_date' => '2025-03-25',
                'end_date' => '2025-04-05',
                'is_special' => true,
                'special_type' => 'Eid',
            ],
            [
                'accommodation_id' => 2,
                'season_name' => 'Summer',
                'start_date' => '2025-05-01',
                'end_date' => '2025-09-15',
                'is_special' => false,
                'special_type' => null,
            ],
        ]);
    }
}
