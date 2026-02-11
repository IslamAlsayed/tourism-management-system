<?php

namespace Modules\Transportation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Transportation\Entities\Pricing>
 */
class PricingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->numberBetween(900, 4000),
            'tax' => $this->faker->randomFloat(2, 0, 100),
            'is_active' => $this->faker->boolean(80),
            'description' => $this->faker->paragraph(3),
            'notes' => $this->faker->optional()->sentence(),
            'company_id' => \Modules\Transportation\Entities\Company::inRandomOrder()->first()?->id ?? \Modules\Transportation\Entities\Company::factory(),
            'vehicle_type_id' => \Modules\Transportation\Entities\VehicleType::inRandomOrder()->first()?->id ?? null,
            'season_id' => \Modules\Accommodations\Entities\Season::inRandomOrder()->first()?->id ?? null,
            'pricing_unit_id' => \Modules\Core\Entities\PricingDefinition::inRandomOrder()->first()?->id ?? \Modules\Core\Entities\PricingDefinition::factory(),
            'currency_id' => \Modules\Localization\Entities\Currency::inRandomOrder()->first()?->id ?? \Modules\Localization\Entities\Currency::factory(),
        ];
    }
}
