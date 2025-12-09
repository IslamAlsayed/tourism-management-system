<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccommodationMealRate>
 */
class AccommodationMealRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'accommodation_id' => \App\Models\Accommodation::factory(),
            'season_id' => \App\Models\Season::inRandomOrder()->first()?->id ?? \App\Models\Season::factory(),
            'meal_id' => \App\Models\Meal::inRandomOrder()->first()?->id ?? \App\Models\Meal::factory(),
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? \App\Models\Currency::factory(),
            'price' => fake()->randomFloat(2, 10, 100),
            'is_supplement' => fake()->boolean(60),
            'is_active' => fake()->boolean(90),
            'notes' => fake()->paragraph(1),
        ];
    }
}