<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            ['name' => 'Single room', 'name_ar' => 'غرفة مفردة', 'max_occupancy' => 1, 'occupancy_details' => '1A'],
            ['name' => 'Double room', 'name_ar' => 'غرفة مزدوجة', 'max_occupancy' => 3, 'occupancy_details' => '2A+1C'],
            ['name' => 'Triple room', 'name_ar' => 'غرفة ثلاثية', 'max_occupancy' => 3, 'occupancy_details' => '3A'],
            ['name' => 'Quad room', 'name_ar' => 'غرفة رباعية', 'max_occupancy' => 4, 'occupancy_details' => '4A'],
            ['name' => 'Junior suite', 'name_ar' => 'جناح صغير', 'max_occupancy' => 2, 'occupancy_details' => '1A+1C'],
        ];

        $type = $this->faker->unique()->randomElement($types);

        // Randomly choose between Restaurant or Accommodation
        $modelType = $this->faker->randomElement([
            \App\Models\Restaurant::class,
            \App\Models\Accommodation::class,
        ]);
        $modelInstance = $modelType::inRandomOrder()->first();

        return [
            'model_id' => $modelInstance?->id,
            'model_type' => $modelInstance ? $modelType : null,

            // 'season_id' => \App\Models\Season::inRandomOrder()->first()?->id ?? null,
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? null,
            'name' => $type['name'],
            'name_ar' => $type['name_ar'],
            'max_occupancy' => $type['max_occupancy'],
            'occupancy_details' => $type['occupancy_details'],
            'price_per_person_double' => $this->faker->randomFloat(2, 50, 500),
            'single_room_supplement' => $this->faker->randomFloat(2, 20, 100),
            'triple_room_discount' => $this->faker->randomFloat(2, 10, 50),
            'third_person_price' => $this->faker->randomFloat(2, 30, 200),
            'extra_bed_price' => $this->faker->randomFloat(2, 25, 150),
            'sea_view_supplement' => $this->faker->randomFloat(2, 30, 100),
            'is_active' => $this->faker->boolean(90),
            'description' => $this->faker->paragraph(2),
            'notes' => $this->faker->optional()->paragraph(1),
        ];
    }
}