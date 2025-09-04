<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Subregion;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 7; $i++) {
            Supplier::create([
                'continent' => fake()->randomElement(['Asia', 'Europe', 'Africa', 'North America', 'South America', 'Australia']),
                'timezone' => fake()->timezone(),
                'nationality' => fake()->randomElement(['Jordanian', 'Egyptian']),
                'category' => fake()->randomElement(['tour operator', 'travel agency', 'hotel', 'transportation', 'other']),
                'sector' => fake()->randomElement(['public', 'private']),
                'business_type' => fake()->randomElement(['B2B', 'B2C']),
                'company_name' => fake()->company(),
                'contact_person_name' => fake()->name(),
                'job_title' => fake()->jobTitle(),
                'department' => fake()->word(),
                'mobile_phone' => fake()->phoneNumber(),
                'work_phone' => fake()->phoneNumber(),
                'work_phone_ext' => fake()->numberBetween(100, 999),
                'fax_number' => fake()->phoneNumber(),
                'work_email' => fake()->unique()->safeEmail(),
                'personal_email' => fake()->unique()->safeEmail(),
                'secondary_email' => fake()->unique()->safeEmail(),
                'website' => fake()->url(),
                'primary_phone' => fake()->phoneNumber(),
                'secondary_phone' => fake()->phoneNumber(),
                'box' => fake()->buildingNumber(),
                'postal_code' => fake()->postcode(),
                'street_address' => fake()->streetAddress(),
                'business_registration_number' => fake()->bothify('BRN-#####'),
                'tax_id' => fake()->bothify('TAX-#####'),
                'status' => fake()->randomElement(['active', 'inactive']),
                'notes' => fake()->paragraph(),
                'country_id' => Country::inRandomOrder()->first()?->id ?? 1,
                'state_id' => State::inRandomOrder()->first()?->id ?? 1,
                'city_id' => City::inRandomOrder()->first()?->id ?? 1,
                'region_id' => Region::inRandomOrder()->first()?->id ?? 1,
                'subregion_id' => Subregion::inRandomOrder()->first()?->id ?? 1,
            ]);
        }
    }
}