<?php

namespace Modules\Accommodations\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Accommodations\Entities\Meal>

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

        $type = $this->faker->unique()->randomElement($types);

        // Randomly choose between Restaurant or Accommodation
        $modelType = $this->faker->randomElement([
            \Modules\Restaurants\Entities\Restaurant::class,
            \Modules\Accommodations\Entities\Accommodation::class,
        ]);
        $modelInstance = $modelType::inRandomOrder()->first();

        return [
            'model_id' => $modelInstance?->id,
            'model_type' => $modelInstance ? $modelType : null,

            'currency_id' => \Modules\Localization\Entities\Currency::inRandomOrder()->first()?->id ?? null,
            'name' => $type['name'],
            'name_ar' => $type['name_ar'],
            'price' => $this->faker->randomFloat(2, 10, 100),
            'is_included' => $type['included'],
            'is_supplement' => $this->faker->boolean(60),
            'is_active' => $this->faker->boolean(90),
            'description' => $this->faker->optional()->paragraph(2),
            'notes' => $this->faker->optional()->paragraph(1),
        ];
    }
}
