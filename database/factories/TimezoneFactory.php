<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timezone>
 */
class TimezoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timezones = [
            ['name' => 'America/New_York', 'offset' => -18000, 'abbreviation' => 'EST', 'city' => 'New York', 'region' => 'America'],
            ['name' => 'America/Los_Angeles', 'offset' => -28800, 'abbreviation' => 'PST', 'city' => 'Los Angeles', 'region' => 'America'],
            ['name' => 'Europe/London', 'offset' => 0, 'abbreviation' => 'GMT', 'city' => 'London', 'region' => 'Europe'],
            ['name' => 'Europe/Paris', 'offset' => 3600, 'abbreviation' => 'CET', 'city' => 'Paris', 'region' => 'Europe'],
            ['name' => 'Asia/Tokyo', 'offset' => 32400, 'abbreviation' => 'JST', 'city' => 'Tokyo', 'region' => 'Asia'],
            ['name' => 'Asia/Dubai', 'offset' => 14400, 'abbreviation' => 'GST', 'city' => 'Dubai', 'region' => 'Asia'],
            ['name' => 'Asia/Riyadh', 'offset' => 10800, 'abbreviation' => 'AST', 'city' => 'Riyadh', 'region' => 'Asia'],
            ['name' => 'Africa/Cairo', 'offset' => 7200, 'abbreviation' => 'EET', 'city' => 'Cairo', 'region' => 'Africa'],
        ];

        $timezone = $this->faker->unique()->randomElement($timezones);

        $hours = floor(abs($timezone['offset']) / 3600);
        $sign = $timezone['offset'] >= 0 ? '+' : '-';
        $gmtOffsetName = sprintf('UTC%s%02d:00', $sign, $hours);

        return [
            'name' => $timezone['name'],
            'name_ar' => null,
            'abbreviation' => $timezone['abbreviation'],
            'abbreviation_dst' => null,
            'offset' => $timezone['offset'],
            'offset_dst' => null,
            'country_code' => null,
            'gmt_offset_name' => $gmtOffsetName,
            'gmt_offset_name_dst' => null,
            'supports_dst' => $this->faker->boolean(30),
            'region' => $timezone['region'],
            'city' => $timezone['city'],
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}