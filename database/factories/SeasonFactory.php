<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Season>
 */
class SeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seasons = [
            ['name' => 'Winter Season', 'name_ar' => 'موسم الشتاء', 'from' => '2024-12-01', 'to' => '2025-02-28'],
            ['name' => 'Spring Season', 'name_ar' => 'موسم الربيع', 'from' => '2025-03-01', 'to' => '2025-05-31'],
            ['name' => 'Summer Season', 'name_ar' => 'موسم الصيف', 'from' => '2025-06-01', 'to' => '2025-08-31'],
            ['name' => 'Autumn Season', 'name_ar' => 'موسم الخريف', 'from' => '2025-09-01', 'to' => '2025-11-30'],
            ['name' => 'Holiday Season', 'name_ar' => 'موسم الأعياد', 'from' => '2024-12-20', 'to' => '2025-01-10'],
        ];

        $season = fake()->unique()->randomElement($seasons);

        return [
            'name' => $season['name'],
            'name_ar' => $season['name_ar'],
            'season_from' => $season['from'],
            'season_to' => $season['to'],
            'description' => fake()->paragraph(2),
            'is_active' => fake()->boolean(90),
        ];
    }
}
