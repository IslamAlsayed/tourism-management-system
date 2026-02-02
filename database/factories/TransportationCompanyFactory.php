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
            'name' => $this->faker->company() . ' Transport',
            'name_ar' => $this->faker->randomElement(['شركة النقل الأردنية', 'شركة المواصلات الحديثة', 'نقل الأردن', 'المواصلات السريعة']),
            'code' => $this->faker->unique()->bothify('TC-####'),
            'rating' => $this->faker->numberBetween(1, 5),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'fax' => $this->faker->optional()->phoneNumber(),
            'street' => $this->faker->streetAddress(),
            'box' => $this->faker->optional()->numerify('P.O. Box ####'),
            'postal_code' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'website' => $this->faker->url(),
            'is_active' => $this->faker->boolean(80),
            'description' => $this->faker->paragraph(3),
            'notes' => $this->faker->optional()->sentence(),
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? \App\Models\Currency::factory(),
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id ?? \App\Models\Country::factory(),
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id ?? null,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id ?? null,
        ];
    }
}
