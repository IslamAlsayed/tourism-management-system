<?php

namespace Database\Seeders;

use App\Models\HotelSupplement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HotelSupplementSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        HotelSupplement::truncate();
        Schema::enableForeignKeyConstraints();

        HotelSupplement::insert([
            [
                'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'name' => 'New Year Eve Dinner',
                'price' => 60.00,
                'is_per_person' => true,
                'is_mandatory' => true,
                'applicable_date' => '2025-12-31',
            ],
            [
                'hotel_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'accommodation_id' => \App\Models\Accommodation::inRandomOrder()->first()?->id ?? 1,
                'name' => 'Lunch Supplement',
                'price' => 15.00,
                'is_per_person' => true,
                'is_mandatory' => false,
                'applicable_date' => null,
            ]
        ]);
    }
}