<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Subregion;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Accommodation;
use App\Models\Region;
use App\Models\City;
use Illuminate\Support\Facades\Schema;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Hotel::truncate();
        Schema::enableForeignKeyConstraints();

        for ($i = 0; $i < 90; $i++) {
            Hotel::create([
                'name' => fake()->company() . ' Hotel',
                'created_by' => auth()->id() ?? 1,
                'sales_man' => fake()->name(),
                'sales_phone' => '+962' . rand(100000, 999999) . '900',
                'sales_mail' => fake()->unique()->safeEmail(),
                'reservation_man' => fake()->name(),
                'reservation_phone' => '+962' . rand(100000, 999999) . '901',
                'reservation_mail' => fake()->unique()->safeEmail(),
                'accounting_person' => fake()->name(),
                'accounting_mail' => fake()->unique()->safeEmail(),
                'accounting_phone' => '+962' . rand(100000, 999999) . '902',
                'description' => fake()->paragraph(),
                'country_id' => Country::inRandomOrder()->first()?->id ?? 1,
                'city_id' => City::inRandomOrder()->first()?->id ?? 1,
                'region_id' => Region::inRandomOrder()->first()?->id ?? 1,
                'subregion_id' => Subregion::inRandomOrder()->first()?->id ?? 1,
                'accommodation_id' => Accommodation::inRandomOrder()->first()?->id ?? 1,
            ]);
        }
    }
}