<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplement>
 */
class SupplementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $supplements = [
            ['name' => 'Sea View Upgrade', 'name_ar' => 'ترقية إطلالة بحرية', 'category' => 'accommodation'],
            ['name' => 'Airport Transfer', 'name_ar' => 'نقل من/إلى المطار', 'category' => 'transportation'],
            ['name' => 'Late Check-out', 'name_ar' => 'تأخير المغادرة', 'category' => 'accommodation'],
            ['name' => 'Extra Bed', 'name_ar' => 'سرير إضافي', 'category' => 'accommodation'],
            ['name' => 'Breakfast Upgrade', 'name_ar' => 'ترقية الإفطار', 'category' => 'accommodation'],
            ['name' => 'Spa Package', 'name_ar' => 'باقة سبا', 'category' => 'accommodation'],
            ['name' => 'City Tour', 'name_ar' => 'جولة في المدينة', 'category' => 'accommodation'],
            ['name' => 'Welcome Drink', 'name_ar' => 'مشروب ترحيبي', 'category' => 'accommodation'],
            ['name' => 'New Year Gala Dinner', 'name_ar' => 'عشاء رأس السنة', 'category' => 'accommodation'],
            ['name' => 'Pool View Supplement', 'name_ar' => 'إضافة إطلالة حمام سباحة', 'category' => 'accommodation'],
        ];

        $supplement = fake()->randomElement($supplements);

        // Randomly choose between Restaurant or Accommodation
        $modelType = fake()->randomElement([
            \App\Models\Restaurant::class,
            \App\Models\Accommodation::class,
        ]);
        $modelInstance = $modelType::inRandomOrder()->first();

        return [
            'model_id' => $modelInstance?->id,
            'model_type' => $modelInstance ? $modelType : null,

            'name' => $supplement['name'],
            'name_ar' => $supplement['name_ar'],
            'description' => fake()->paragraph(2),
            // 'description_ar' => fake()->paragraph(2),
            // 'category' => $supplement['category'],
            'price' => fake()->randomFloat(2, 10, 200),
            // 'is_per_person' => fake()->boolean(60),
            'price_type' => fake()->randomElement(['per_person', 'per_room', 'per_night', 'one_time']),
            'is_mandatory' => fake()->boolean(20),
            'applicable_date' => fake()->optional()->dateTimeBetween('now', '+1 year'),
            'is_active' => fake()->boolean(90),
            'notes' => fake()->optional()->paragraph(1),
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id ?? null,
            'updated_by' => null,
        ];
    }
}