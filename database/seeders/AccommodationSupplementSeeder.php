<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\AccommodationSupplement;

class AccommodationSupplementSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        AccommodationSupplement::truncate();
        Schema::enableForeignKeyConstraints();

        AccommodationSupplement::insert([
            [
                'name' => 'New Year Gala Dinner',
                'price' => 50.00,
                'is_per_person' => true,
                'is_mandatory' => true,
                'applicable_date' => '2025-12-31',
                'accommodation_id' => Accommodation::inRandomOrder()->first()?->id ?? 1,
            ],
            [
                'name' => 'Lunch Supplement',
                'price' => 20.00,
                'is_per_person' => true,
                'is_mandatory' => false,
                'applicable_date' => null,
                'accommodation_id' => Accommodation::inRandomOrder()->first()?->id ?? 1,
            ],
        ]);
    }
}