<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            ['name' => 'Breakfast', 'name_ar' => 'إفطار', 'included' => true],
            ['name' => 'Lunch', 'name_ar' => 'غداء', 'included' => false],
            ['name' => 'Dinner', 'name_ar' => 'عشاء', 'included' => false],
            ['name' => 'Half Board', 'name_ar' => 'إقامة نصف إقامة', 'included' => true],
            ['name' => 'Full Board', 'name_ar' => 'إقامة كاملة', 'included' => true],
        ];

        $type = fake()->unique()->randomElement($types);

        return [
            'name' => $type['name'],
            'name_ar' => $type['name_ar'],
            'is_included' => $type['included'],
            'notes' => fake()->paragraph(2),
            'is_active' => fake()->boolean(90),
        ];
    }
}