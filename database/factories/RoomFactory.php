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

        $type = fake()->unique()->randomElement($types);

        return [
            'name' => $type['name'],
            'name_ar' => $type['name_ar'],
            'max_occupancy' => $type['max_occupancy'],
            'occupancy_details' => $type['occupancy_details'],
            'description' => fake()->paragraph(2),
            'is_active' => fake()->boolean(90),
        ];
    }
}