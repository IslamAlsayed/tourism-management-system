<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\TouristSite;
use App\Models\TouristService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TouristService>
 */
class TouristServiceFactory extends Factory
{
    protected $model = TouristService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Foreign Keys
            'site_id' => TouristSite::inRandomOrder()->first()?->id ?? TouristSite::factory(),
            'currency_id' => Currency::inRandomOrder()->first()?->id ?? 1,

            // Service Configuration
            'include_unified_ticket' => $this->faker->boolean(40),
            'total_day_visit' => $this->faker->optional(0.6)->randomFloat(2, 50, 500),

            // Pricing - Foreigners
            'per_adult_foreigners' => $this->faker->randomFloat(2, 100, 500),
            'per_child_foreigners' => $this->faker->randomFloat(2, 50, 250),

            // Pricing - Local
            'per_adult_local' => $this->faker->randomFloat(2, 20, 100),
            'per_child_local' => $this->faker->randomFloat(2, 10, 50),

            // Pricing - Arab
            'per_adult_arab' => $this->faker->randomFloat(2, 50, 200),
            'per_child_arab' => $this->faker->randomFloat(2, 25, 100),

            // Pricing - Residents
            'per_adult_residents' => $this->faker->randomFloat(2, 40, 150),
            'per_child_residents' => $this->faker->randomFloat(2, 20, 75),

            // Non-accommodated Visitors
            'non_accommodated_visitors_adult' => $this->faker->randomFloat(2, 30, 120),
            'non_accommodated_visitors_child' => $this->faker->randomFloat(2, 15, 60),

            // Operating Hours
            'summer_opening_time' => $this->faker->randomElement(['06:00', '07:00', '08:00', '09:00']),
            'summer_closing_time' => $this->faker->randomElement(['17:00', '18:00', '19:00', '20:00']),
            'winter_opening_time' => $this->faker->randomElement(['07:00', '08:00', '09:00', '10:00']),
            'winter_closing_time' => $this->faker->randomElement(['16:00', '17:00', '18:00', '19:00']),
            'operating_days' => fake()->randomElements(
                ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                $this->faker->numberBetween(5, 7)
            ),
            'annual_holidays' => array_map(fn() => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'), range(1, rand(1, 10))),
            'day_off' => fake()->randomElements(
                ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                $this->faker->numberBetween(0, 2)
            ),
            'yearly_holidays' => ['Ramadan', 'Eid'],
            // Contact Information
            'phone' => $this->faker->optional(0.7)->phoneNumber(),
            'fax' => $this->faker->optional(0.5)->phoneNumber(),
            'mobile_01' => $this->faker->optional(0.8)->phoneNumber(),
            'mobile_02' => $this->faker->optional(0.6)->phoneNumber(),
            'person_name_01' => $this->faker->optional(0.7)->firstName(),
            'person_name_02' => $this->faker->optional(0.5)->firstName(),
            'email_01' => $this->faker->optional(0.7)->safeEmail(),
            'email_02' => $this->faker->optional(0.5)->safeEmail(),
            'website' => $this->faker->optional(0.6)->url(),

            // Local Guide
            'local_guide_available' => $this->faker->boolean(70),
            'local_guide_fees_01' => $this->faker->randomFloat(2, 100, 300),
            'local_guide_fees_02' => $this->faker->randomFloat(2, 150, 400),
            'local_guide_fees_03' => $this->faker->randomFloat(2, 200, 500),
            'local_guide_fees_04' => $this->faker->randomFloat(2, 250, 600),
            'local_guide_fees_05' => $this->faker->randomFloat(2, 300, 800),

            // Payment Methods
            'credit_cards' => $this->faker->boolean(80),

            // Club Cars
            'club_cars_available' => $this->faker->boolean(60),
            'club_car_prices_01' => $this->faker->randomFloat(2, 50, 100),
            'club_car_prices_02' => $this->faker->randomFloat(2, 80, 150),
            'club_car_prices_03' => $this->faker->randomFloat(2, 100, 180),
            'club_car_prices_04' => $this->faker->randomFloat(2, 120, 200),
            'club_car_prices_05' => $this->faker->randomFloat(2, 150, 250),
            'club_car_prices_06' => $this->faker->randomFloat(2, 180, 300),
            'club_car_prices_07' => $this->faker->randomFloat(2, 200, 350),
            'club_car_prices_08' => $this->faker->randomFloat(2, 250, 400),

            // Additional Fields
            'ext1' => $this->faker->optional(0.3)->word(),
            'ext2' => $this->faker->optional(0.3)->word(),
            'ext3' => $this->faker->optional(0.3)->word(),

            // Description & Notes
            'description' => $this->faker->paragraph(),
            'notes' => $this->faker->optional(0.4)->paragraph(),

            // Status
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(85),

            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the tourist site is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the tourist site is featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the tourist site has free entry.
     */
    public function freeEntry(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_free_entry' => true,
            'entry_fee_adult' => 0,
            'entry_fee_child' => 0,
            'entry_fee_student' => 0,
            'entry_fee_senior' => 0,
            'entry_fee_group' => 0,
        ]);
    }

    /**
     * Indicate that the tourist site is historical site_type.
     */
    public function historical(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'historical',
            'category' => 'monument',
        ]);
    }

    /**
     * Indicate that the tourist site is natural site_type.
     */
    public function natural(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'natural',
            'category' => 'attraction',
        ]);
    }

    /**
     * Indicate that the tourist site is a museum.
     */
    public function museum(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'museum',
            'category' => 'facility',
            'has_gift_shop' => true,
            'wheelchair_accessible' => true,
        ]);
    }
}