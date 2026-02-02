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
            'name' => $this->faker->company() . ' ' . $this->faker->randomElement(['Hotel', 'Resort', 'Lodge', 'Inn']),
            'name_ar' => 'فندق ' . $this->faker->company(),
            'classification' => $this->faker->randomElement(['Budget', 'Standard', 'Deluxe', 'Luxury', 'Premium']),
            'stars' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->paragraph(3),
            'general_mobile' => $this->faker->phoneNumber(),
            'general_email' => $this->faker->companyEmail(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'phone_ext' => $this->faker->optional()->numerify('###'),
            'fax' => $this->faker->optional()->phoneNumber(),
            'contact_person' => $this->faker->name(),
            'contact_position' => $this->faker->jobTitle(),
            'contact_mobile' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->email(),
            'street' => $this->faker->streetAddress(),
            'box' => $this->faker->optional()->numerify('P.O. Box ####'),
            'postal_code' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'contract_file_path' => null,
            'is_active' => $this->faker->boolean(80),
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? \App\Models\Currency::factory(),
            'type_id' => \App\Models\Type::inRandomOrder()->first()?->id ?? null,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id ?? \App\Models\Country::factory(),
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id ?? null,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id ?? null,
        ];
    }
}
