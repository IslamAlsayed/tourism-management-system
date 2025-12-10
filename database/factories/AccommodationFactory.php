<?php

namespace Database\Factories;

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
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? \App\Models\Currency::factory(),
            'type_id' => \App\Models\Type::inRandomOrder()->first()?->id ?? null,
            'region_id' => \App\Models\Region::inRandomOrder()->first()?->id ?? null,
            'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id ?? null,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id ?? \App\Models\Country::factory(),
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id ?? null,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id ?? null,
        ];
    }
}