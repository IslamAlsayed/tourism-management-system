<?php

namespace Modules\Localization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Localization\Entities\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->unique()->currencyCode(),
            'symbol' => $this->faker->lexify('???'),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
