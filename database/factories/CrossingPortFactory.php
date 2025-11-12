<?php

namespace Database\Factories;

use App\Models\CrossingPort;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CrossingPort>
 */
class CrossingPortFactory extends Factory
{
    protected $model = CrossingPort::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(array_keys(config('helpers.crossing_port_types')));

        $name = $this->generateNameByType($type);
        $nameAr = $this->generateArabicNameByType($type);

        // Generate coordinates (focusing on Middle East region)
        $latitude = $this->faker->randomFloat(6, 15.0, 35.0); // Rough Middle East latitude range
        $longitude = $this->faker->randomFloat(6, 30.0, 60.0); // Rough Middle East longitude range

        return [
            'code' => $this->generateCodeByType($type),
            'name' => $name,
            'name_ar' => $nameAr,
            'description' => $this->faker->optional(0.7)->paragraph(),

            // Location information
            'region_id' => \App\Models\Region::inRandomOrder()->first()?->id,
            'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id,
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id,

            'type' => $type,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'elevation' => $type === 'international_airport' || $type === 'domestic_airport' ? $this->faker->numberBetween(0, 3000) . ' ft' : null,

            // Operating information
            'is_operational' => $this->faker->boolean(85), // 85% operational
            'is_24_hours' => $this->faker->boolean($type === 'international_airport' ? 70 : 30),
            'opening_time' => $this->faker->optional(0.6)->time('H:i'),
            'closing_time' => $this->faker->optional(0.6)->time('H:i'),
            'operating_days' => $this->faker->optional(0.8)->randomElements(array_keys(config('helpers.days')), $this->faker->numberBetween(5, 7)),

            // Facilities and services
            'facilities' => $this->generateFacilitiesByType($type),
            'services' => $this->generateServicesByType($type),

            // Contact information
            'phone' => $this->faker->optional(0.8)->phoneNumber(),
            'fax' => $this->faker->optional(0.4)->phoneNumber(),
            'email' => $this->faker->optional(0.6)->companyEmail(),
            'website' => $this->faker->optional(0.5)->url(),

            // Address
            'address' => $this->faker->optional(0.8)->address(),
            'postal_code' => $this->faker->optional(0.7)->postcode(),

            // Additional information
            'capacity' => $this->generateCapacityByType($type),
            'runway_info' => $type === 'international_airport' || $type === 'domestic_airport'
                ? $this->generateRunwayInfo()
                : null,
            'customs_office' => $this->faker->optional(0.6)->company() . ' Customs Office',
            'immigration_office' => $this->faker->optional(0.6)->company() . ' Immigration Office',

            // Status and preferences
            'status' => $this->faker->randomElement(array_keys(config('helpers.crossing_port_statuses'))),
            'notes' => $this->faker->optional(0.4)->paragraph(),

            // Images and documents (as JSON arrays)
            'images' => $this->faker->optional(0.3)->randomElements([
                'crossing_port_1.jpg',
                'crossing_port_2.jpg',
                'crossing_port_3.jpg'
            ], $this->faker->numberBetween(1, 3)),
            'documents' => $this->faker->optional(0.4)->randomElements([
                'license.pdf',
                'regulations.pdf',
                'map.pdf'
            ], $this->faker->numberBetween(1, 2)),

            // Tracking
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'updated_by' => null,
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
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
     * Generate facilities based on type
     */
    private function generateFacilitiesByType($type)
    {
        $commonFacilities = ['customs', 'immigration', 'security'];

        switch ($type) {
            case 'international_airport':
                return array_merge($commonFacilities, ['duty_free', 'vip_lounge', 'restaurants', 'currency_exchange']);
            case 'domestic_airport':
                return array_merge($commonFacilities, ['restaurants', 'shops']);
            case 'seaport':
                return array_merge($commonFacilities, ['cargo_handling', 'passenger_terminal', 'parking']);
            default:
                return $commonFacilities;
        }
    }

    /**
     * Generate services based on type
     */
    private function generateServicesByType($type)
    {
        $services = [];
        if ($type === 'international_airport' || $type === 'domestic_airport') {
            $services = ['baggage_handling', 'ground_services', 'fueling'];
        } elseif ($type === 'seaport') {
            $services = ['cargo_services', 'passenger_services', 'ship_services'];
        } else {
            $services = ['inspection_services', 'document_processing'];
        }

        return $this->faker->optional(0.6)->randomElements($services, $this->faker->numberBetween(1, count($services)));
    }

    /**
     * Generate capacity based on type
     */
    private function generateCapacityByType($type)
    {
        switch ($type) {
            case 'international_airport':
                return $this->faker->numberBetween(500, 5000); // passengers per hour
            case 'domestic_airport':
                return $this->faker->numberBetween(100, 1000);
            case 'seaport':
                return $this->faker->numberBetween(1000, 10000); // passengers per day
            default:
                return $this->faker->numberBetween(50, 500);
        }
    }

    /**
     * Generate runway information for airports
     */
    private function generateRunwayInfo()
    {
        return [
            'length' => $this->faker->numberBetween(1500, 4000) . 'm',
            'width' => $this->faker->numberBetween(30, 60) . 'm',
            'surface' => $this->faker->randomElement(['asphalt', 'concrete', 'gravel']),
            'lighting' => $this->faker->boolean(80)
        ];
    }

    /**
     * Create an international airport
     */
    public function internationalAirport()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'international_airport',
            'is_24_hours' => true,
            'is_operational' => true,
            'status' => 'active',
        ]);
    }

    /**
     * Create a domestic airport
     */
    public function domesticAirport()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'domestic_airport',
            'is_24_hours' => $this->faker->boolean(60),
            'is_operational' => true,
            'status' => 'active',
        ]);
    }

    /**
     * Create a seaport
     */
    public function seaport()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'seaport',
            'elevation' => null,
            'runway_info' => null,
        ]);
    }

    /**
     * Create a land crossing
     */
    public function landCrossing()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'land_crossing',
            'elevation' => null,
            'runway_info' => null,
            'is_24_hours' => $this->faker->boolean(40),
        ]);
    }
}