<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransportationCompany>
 */
class TransportationCompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Transport',
            'name_ar' => fake()->randomElement(['شركة النقل الأردنية', 'شركة المواصلات الحديثة', 'نقل الأردن', 'المواصلات السريعة']),
            'code' => fake()->unique()->bothify('TC-####'),
            'rating' => fake()->numberBetween(1, 5),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'mobile' => fake()->phoneNumber(),
            'fax' => fake()->optional()->phoneNumber(),
            'street' => fake()->streetAddress(),
            'box' => fake()->optional()->numerify('P.O. Box ####'),
            'postal_code' => fake()->postcode(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'website' => fake()->url(),
            'is_active' => fake()->boolean(80),
            'description' => fake()->paragraph(3),
            'notes' => fake()->optional()->sentence(),
            'timezone_id' => \App\Models\Timezone::inRandomOrder()->first()?->id ?? \App\Models\Timezone::factory(),
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? \App\Models\Currency::factory(),
            'region_id' => \App\Models\Region::inRandomOrder()->first()?->id ?? null,
            'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id ?? null,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id ?? \App\Models\Country::factory(),
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id ?? null,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id ?? null,
        ];
    }
}