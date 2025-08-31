<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccommodationSupplementSeeder extends Seeder
{
    public function run()
    {
        DB::table('accommodation_supplements')->insert([
            [
                'accommodation_id' => 1,
                'name' => 'New Year Gala Dinner',
                'price' => 50.00,
                'is_per_person' => true,
                'is_mandatory' => true,
                'applicable_date' => '2025-12-31',
            ],
            [
                'accommodation_id' => 1,
                'name' => 'Lunch Supplement',
                'price' => 20.00,
                'is_per_person' => true,
                'is_mandatory' => false,
                'applicable_date' => null,
            ],
        ]);
    }
}
