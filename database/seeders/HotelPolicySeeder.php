<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelPolicySeeder extends Seeder
{
    public function run()
    {
        DB::table('hotel_policies')->insert([
            [
                'accommodation_id' => 1,
                'policy_type' => 'Cancellation - High Season',
                'details' => 'Cancellation within 7 days: 100% charge. Cancellation 8-14 days: 50% charge.',
            ],
            [
                'accommodation_id' => 1,
                'policy_type' => 'Children Policy',
                'details' => 'Children under 6 years stay free in parents room.',
            ]
        ]);
    }
}
