<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Airline;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airline>
 */
class AirlineFactory extends Factory
{
    protected $model = Airline::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $airportName = $this->generateAirportName();

        return [
            'icao' => $this->generateICAO(),
            'iata' => $this->generateIATA(),
            'lid' => $this->faker->optional()->bothify('??###'),
            'name' => $airportName,
            'name_ar' => $this->generateArabicName($airportName),
            'subd' => $this->faker->randomElement(['International', 'Regional', 'Domestic', 'Military', 'Private']),
            'region_id' => \App\Models\Region::inRandomOrder()->first()?->id,
            'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id,
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id,
            'elevation' => $this->faker->randomFloat(2, 0, 5000),
            'latitude' => $this->faker->latitude(15, 35),
            'longitude' => $this->faker->longitude(25, 60),
            'timezone_id' => \App\Models\Timezone::inRandomOrder()->first()?->id,
            'local_phone_number' => $this->faker->phoneNumber(),
            'international_phone_number' => $this->faker->numerify('+966-##-###-####'),
            'website' => 'https://www.' . strtolower(str_replace(' ', '', $airportName)) . '.aero',
        ];
    }

    private function generateAirportName(): string
    {
        $cities = ['Riyadh', 'Jeddah', 'Dubai', 'Doha', 'Kuwait', 'Cairo', 'Amman', 'Baghdad', 'Muscat', 'Manama', 'Beirut', 'Damascus'];
        $types = ['International Airport', 'Regional Airport', 'Domestic Airport'];

        $city = $this->faker->randomElement($cities);
        $type = $this->faker->randomElement($types);

        return "{$city} {$type}";
    }

    private function generateArabicName(string $englishName): string
    {
        $translations = [
            'Riyadh' => 'الرياض',
            'Jeddah' => 'جدة',
            'Dubai' => 'دبي',
            'Doha' => 'الدوحة',
            'Kuwait' => 'الكويت',
            'Cairo' => 'القاهرة',
            'Amman' => 'عمان',
            'Baghdad' => 'بغداد',
            'Muscat' => 'مسقط',
            'Manama' => 'المنامة',
            'Beirut' => 'بيروت',
            'Damascus' => 'دمشق',
            'International Airport' => 'مطار دولي',
            'Regional Airport' => 'مطار إقليمي',
            'Domestic Airport' => 'مطار محلي',
        ];

        $arabicName = $englishName;
        foreach ($translations as $en => $ar) {
            $arabicName = str_replace($en, $ar, $arabicName);
        }

        return $arabicName;
    }

    private function generateICAO(): string
    {
        // ICAO codes are 4 letters - generate unique codes
        static $usedICAO = [];

        $prefixes = ['OE', 'OM', 'OI', 'OS', 'OT', 'HE', 'OJ', 'OR', 'OK', 'LT', 'LB', 'OS', 'OY'];

        $attempts = 0;
        $maxAttempts = 100;

        do {
            $prefix = $this->faker->randomElement($prefixes);
            $suffix = strtoupper($this->faker->bothify('??'));
            $code = $prefix . $suffix;
            $attempts++;

            if ($attempts >= $maxAttempts) {
                // If we can't find unique code, generate completely random
                $code = strtoupper($this->faker->unique()->bothify('????'));
            }
        } while (in_array($code, $usedICAO) && $attempts < $maxAttempts);

        $usedICAO[] = $code;
        return $code;
    }

    private function generateIATA(): string
    {
        // IATA codes are 3 letters - use unique faker to avoid duplicates
        return strtoupper($this->faker->unique()->bothify('???'));
    }
}
