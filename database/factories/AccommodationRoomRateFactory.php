<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccommodationRoomRate>
 */
class AccommodationRoomRateFactory extends Factory
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
            'room_id' => \App\Models\Room::inRandomOrder()->first()?->id ?? \App\Models\Room::factory(),
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? \App\Models\Currency::factory(),
            'price_per_person_double' => fake()->randomFloat(2, 50, 500),
            'single_room_supplement' => fake()->randomFloat(2, 20, 100),
            'triple_room_discount' => fake()->randomFloat(2, 10, 50),
            'third_person_price' => fake()->randomFloat(2, 30, 200),
            'extra_bed_price' => fake()->randomFloat(2, 25, 150),
            'sea_view_supplement' => fake()->randomFloat(2, 30, 100),
            'is_active' => fake()->boolean(90),
            'notes' => fake()->paragraph(2),
        ];
    }
}