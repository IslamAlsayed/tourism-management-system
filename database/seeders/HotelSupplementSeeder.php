<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSupplementSeeder extends Seeder
{
    public function run()
    {
        DB::table('hotel_supplements')->insert([
            [
                'accommodation_id' => 1,
                'name' => 'New Year Eve Dinner',
                'price' => 60.00,
                'is_per_person' => true,
                'is_mandatory' => true,
                'applicable_date' => '2025-12-31',
            ],
            [
                'accommodation_id' => 1,
                'name' => 'Lunch Supplement',
                'price' => 15.00,
                'is_per_person' => true,
                'is_mandatory' => false,
                'applicable_date' => null,
            ]
        ]);
    }
}
