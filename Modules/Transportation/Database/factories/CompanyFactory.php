<?php

namespace Modules\Transportation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Transportation\Entities\Company>
 */
class CompanyFactory extends Factory
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
            'currency_id' => \Modules\Localization\Entities\Currency::inRandomOrder()->first()?->id ?? \Modules\Localization\Entities\Currency::factory(),
            'country_id' => \Modules\Geography\Entities\Country::inRandomOrder()->first()?->id ?? \Modules\Geography\Entities\Country::factory(),
            'state_id' => \Modules\Geography\Entities\State::inRandomOrder()->first()?->id ?? null,
            'city_id' => \Modules\Geography\Entities\City::inRandomOrder()->first()?->id ?? null,
        ];
    }
}
