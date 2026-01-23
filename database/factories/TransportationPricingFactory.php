<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransportationPricing>
 */
class TransportationPricingFactory extends Factory
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
            'company_id' => \App\Models\TransportationCompany::inRandomOrder()->first()?->id ?? \App\Models\TransportationCompany::factory(),
            'vehicle_type_id' => \App\Models\TransportationVehicleType::inRandomOrder()->first()?->id ?? null,
            'season_id' => \App\Models\Season::inRandomOrder()->first()?->id ?? null,
            'pricing_unit_id' => \App\Models\PricingDefinition::inRandomOrder()->first()?->id ?? \App\Models\PricingDefinition::factory(),
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? \App\Models\Currency::factory(),
        ];
    }
}