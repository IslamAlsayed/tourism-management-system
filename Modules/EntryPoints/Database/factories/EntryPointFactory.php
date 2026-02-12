<?php

namespace Database\Factories;

use Modules\EntryPoints\Entities\Landcrossing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EntryPoint>
 */
class EntryPointFactory extends Factory
{
    protected $model = Landcrossing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['land_crossing', 'international_airport', 'domestic_airport', 'seaport', 'river_port', 'border_crossing'];
        $type = $this->faker->randomElement($types);

        $name = $this->generateNameByType($type);
        $nameAr = $this->generateArabicNameByType($type);

        // Generate coordinates (focusing on Middle East region)
        $latitude = $this->faker->randomFloat(6, 15.0, 35.0);
        $longitude = $this->faker->randomFloat(6, 30.0, 60.0);

        $is24_7 = $this->faker->boolean($type === 'international_airport' ? 70 : 30);
        $operatingHours = $is24_7 ? '24 Hours' : $this->faker->randomElement(['06:00 - 22:00', '08:00 - 18:00', '09:00 - 17:00', '24/7']);

        return [
            // Location information
            'country_id' => \Modules\Geography\Entities\Country::inRandomOrder()->first()?->id,
            'state_id' => \Modules\Geography\Entities\State::inRandomOrder()->first()?->id,
            'city_id' => \Modules\Geography\Entities\City::inRandomOrder()->first()?->id,
            'address' => $this->faker->optional(0.8)->address(),

            // Basic information
            'name' => $name,
            'name_ar' => $nameAr,
            'type' => $type,
            'code' => $this->generateCodeByType($type),

            // Geographic coordinates
            'latitude' => $latitude,
            'longitude' => $longitude,

            // Operating information
            'operating_hours' => $operatingHours,
            'is_24_7' => $is24_7,
            'is_active' => $this->faker->boolean(85),
            'is_commercial' => $this->faker->boolean(60),
            'is_passenger' => $this->faker->boolean(80),
            'is_international' => $type === 'international_airport' || $this->faker->boolean(30),

            // Visa and immigration policies
            'allows_visa_on_arrival' => $this->faker->boolean(40),
            'nationality_policy' => $this->generateNationalityPolicies(),
            'departure_tax' => $this->faker->optional(0.7)->randomFloat(2, 10, 100),
            'departure_tax_currency_id' => \Modules\Localization\Entities\Currency::inRandomOrder()->first()?->id,

            // Contact information
            'phone' => $this->faker->optional(0.8)->phoneNumber(),
            'email' => $this->faker->optional(0.6)->companyEmail(),
            'website' => $this->faker->optional(0.5)->url(),

            // Display and classification
            'sort_order' => $this->faker->numberBetween(1, 100),
            'is_major' => $this->faker->boolean($type === 'international_airport' ? 60 : 20),

            // Visa requirements
            'visa_required' => $this->faker->boolean(70),
            'visa_fee' => $this->faker->optional(0.8)->randomFloat(2, 20, 200),
            'visa_fee_currency_id' => \Modules\Localization\Entities\Currency::inRandomOrder()->first()?->id,
            'visa_duration' => $this->faker->optional(0.8)->randomElement([30, 60, 90, 180]),
            'visa_conditions' => $this->faker->optional(0.5)->paragraph(),
            'visa_application_url' => $this->faker->optional(0.4)->url(),
            'visa_policy_source' => $this->faker->optional(0.3)->url(),
            'visa_last_update' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),

            // Additional notes
            'description' => $this->faker->optional(0.7)->paragraph(),
            'notes' => $this->faker->optional(0.4)->paragraph(),
        ];
    }

    /**
     * Generate name based on type
     */
    private function generateNameByType($type): string
    {
        switch ($type) {
            case 'international_airport':
                return $this->faker->city() . ' International Airport';
            case 'domestic_airport':
                return $this->faker->city() . ' Domestic Airport';
            case 'seaport':
                return $this->faker->city() . ' Seaport';
            case 'river_port':
                return $this->faker->city() . ' River Port';
            case 'land_crossing':
            case 'border_crossing':
                return $this->faker->city() . ' Border Crossing';
            default:
                return $this->faker->city() . ' ' . ucfirst(str_replace('_', ' ', $type));
        }
    }

    /**
     * Generate Arabic name based on type
     */
    private function generateArabicNameByType($type): string
    {
        $cityNames = ['الرياض', 'جدة', 'الدمام', 'مكة', 'المدينة', 'الطائف', 'أبها', 'تبوك'];
        $city = $this->faker->randomElement($cityNames);

        switch ($type) {
            case 'international_airport':
                return 'مطار ' . $city . ' الدولي';
            case 'domestic_airport':
                return 'مطار ' . $city . ' المحلي';
            case 'seaport':
                return 'ميناء ' . $city . ' البحري';
            case 'river_port':
                return 'ميناء ' . $city . ' النهري';
            case 'land_crossing':
            case 'border_crossing':
                return 'معبر ' . $city . ' الحدودي';
            default:
                return $city . ' ' . $type;
        }
    }

    /**
     * Generate code based on type
     */
    private function generateCodeByType($type): ?string
    {
        if ($type === 'international_airport' || $type === 'domestic_airport') {
            return $this->faker->regexify('[A-Z]{3}'); // ICAO style code
        }
        return $this->faker->optional(0.7)->regexify('[A-Z]{2}[0-9]{3}');
    }

    /**
     * Generate nationality policies
     */
    private function generateNationalityPolicies()
    {
        $countries = ['US', 'UK', 'DE', 'FR', 'JP', 'AU', 'CA', 'IT', 'ES', 'NL'];
        $policies = [];

        foreach ($this->faker->randomElements($countries, $this->faker->numberBetween(3, 8)) as $country) {
            $policies[$country] = $this->faker->randomElement(['visa_free', 'visa_on_arrival', 'visa_required', 'entry_denied']);
        }

        return $policies;
    }



    /**
     * Create an international airport
     */
    public function internationalAirport()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'international_airport',
            'is_24_7' => true,
            'is_active' => true,
            'is_international' => true,
            'is_major' => true,
        ]);
    }

    /**
     * Create a domestic airport
     */
    public function domesticAirport()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'domestic_airport',
            'is_24_7' => $this->faker->boolean(60),
            'is_active' => true,
            'is_international' => false,
        ]);
    }

    /**
     * Create a seaport
     */
    public function seaport()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'seaport',
            'is_commercial' => true,
            'is_passenger' => $this->faker->boolean(70),
        ]);
    }

    /**
     * Create a land crossing
     */
    public function landCrossing()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'land_crossing',
            'is_24_7' => $this->faker->boolean(40),
            'is_commercial' => false,
        ]);
    }
}
