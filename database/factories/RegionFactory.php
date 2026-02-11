<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->city(),
            'name_ar' => $this->faker->unique()->city(),
            'wiki_data_id' => $this->faker->uuid(),
            'is_active' => $this->faker->boolean(),
            'description' => $this->faker->sentence(),
            'notes' => $this->faker->text(),
        ];
    }
}