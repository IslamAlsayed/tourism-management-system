<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Region;
use App\Models\Subregion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accommodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' ' . fake()->randomElement(['Hotel', 'Resort', 'Lodge', 'Inn']),
            'name_ar' => 'فندق ' . fake()->company(),
            'classification' => fake()->randomElement(['Budget', 'Standard', 'Deluxe', 'Luxury', 'Premium']),
            'stars' => fake()->numberBetween(1, 5),
            'description' => fake()->paragraph(3),
            'general_mobile' => fake()->phoneNumber(),
            'general_email' => fake()->companyEmail(),
            'email' => fake()->companyEmail(),
            'website' => fake()->url(),
            'phone' => fake()->phoneNumber(),
            'phone_ext' => fake()->optional()->numerify('###'),
            'fax' => fake()->optional()->phoneNumber(),
            'contact_person' => fake()->name(),
            'contact_position' => fake()->jobTitle(),
            'contact_mobile' => fake()->phoneNumber(),
            'contact_email' => fake()->email(),
            'street' => fake()->streetAddress(),
            'box' => fake()->optional()->numerify('P.O. Box ####'),
            'postal_code' => fake()->postcode(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'contract_file_path' => null,
            'is_active' => fake()->boolean(80),
            'currency_id' => Currency::inRandomOrder()->first()?->id ?? Currency::factory(),
            'region_id' => Region::inRandomOrder()->first()?->id ?? null,
            'subregion_id' => Subregion::inRandomOrder()->first()?->id ?? null,
            'country_id' => Country::inRandomOrder()->first()?->id ?? Country::factory(),
            'state_id' => State::inRandomOrder()->first()?->id ?? null,
            'city_id' => City::inRandomOrder()->first()?->id ?? null,
        ];
    }
}