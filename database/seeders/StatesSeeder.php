<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;

class StatesSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 7; $i++) {
            State::create([
                'name' => fake()->state(),
                'name_ar' => fake()->state(),
                'country_id' => Country::inRandomOrder()->first()?->id ?? 1,
                'iso2' => fake()->countryCode(),
                'iso3166_2' => fake()->stateAbbr(),
                'fips_code' => fake()->word(),
                'type' => fake()->randomElement(['State', 'Province', 'Region']),
                'level' => fake()->numberBetween(1, 3),
                'parent_id' => State::inRandomOrder()->first()?->id ?? null,
                'latitude' => fake()->latitude(),
                'longitude' => fake()->longitude(),
                'timezone' => fake()->timezone(),
            ]);
        }
    }
}