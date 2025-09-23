<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StatesSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        State::truncate();
        Schema::enableForeignKeyConstraints();

        // foreach (range(1, 7) as $i) {
        //     State::create([
        //         'name' => fake()->state(),
        //         'name_ar' => fake()->city(),
        //         'country_id' => Country::inRandomOrder()->first()?->id,
        //         'iso2' => fake()->countryCode(),
        //         'iso3' => null,
        //         'fips_code' => fake()->lexify('??'),
        //         'type' => fake()->randomElement(['State', 'Province', 'Region']),
        //         'level' => fake()->numberBetween(1, 3),
        //         'latitude' => fake()->latitude(),
        //         'longitude' => fake()->longitude(),
        //         'timezone' => fake()->timezone(),
        //     ]);
        // }
    }
}