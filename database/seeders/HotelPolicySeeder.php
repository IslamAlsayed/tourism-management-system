<?php

namespace Database\Seeders;

use App\Models\HotelPolicy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HotelPolicySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        HotelPolicy::truncate();
        Schema::enableForeignKeyConstraints();

        HotelPolicy::insert([
            [
                'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'policy_type' => 'Cancellation - High Season',
                'details' => 'Cancellation within 7 days: 100% charge. Cancellation 8-14 days: 50% charge.',
            ],
            [
                'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'policy_type' => 'Children Policy',
                'details' => 'Children under 6 years stay free in parents room.',
            ]
        ]);
    }
}