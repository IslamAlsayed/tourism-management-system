<?php

namespace Database\Seeders;

use App\Models\Hotel;
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

        foreach (Hotel::all() as $hotel) {
            HotelSupplement::create([
                'hotel_id' => $hotel->id,
                'accommodation_id' => $hotel->accommodation_id,
                'name' => fake()->randomElement(['New Year Eve Dinner', 'Christmas Dinner', 'Easter Brunch']),
                'price' => fake()->randomFloat(2, 20, 100),
                'is_per_person' => fake()->boolean(),
                'is_mandatory' => fake()->boolean(),
                'applicable_date' => fake()->dateTimeBetween('2025-01-01', '2025-12-31')->format('Y-m-d'),
            ]);
        }

    }
}