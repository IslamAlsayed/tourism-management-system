<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AirTransport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AirTransport>
 */
class AirTransportFactory extends Factory
{
    protected $model = AirTransport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['airline', 'charter_company', 'cargo_airline', 'aircraft_operator']);
        $serviceType = $this->getServiceTypeByType($type);

        $airlineName = $this->generateAirlineName();
        $airlineCode = $this->generateAirlineCode($airlineName);

        return [
            'name' => $airlineName,
            'name_ar' => $this->generateArabicName($airlineName),
            'code' => $airlineCode,
            'description' => $this->faker->paragraph(2),
            'type' => $type,
            'service_type' => $serviceType,
            'is_active' => $this->faker->boolean(85),
            'is_international' => $this->faker->boolean(70),
            'is_domestic' => $this->faker->boolean(80),
            'established_date' => $this->faker->dateTimeBetween('-50 years', '-5 years'),
            'hub_airport' => $this->faker->randomElement(['RUH', 'JED', 'DXB', 'DOH', 'KWI', 'CAI', 'AMM', 'BGW']),
            'fleet_size' => $type === 'airline' ? $this->faker->numberBetween(5, 350) : $this->faker->numberBetween(1, 50),
            'aircraft_types' => $this->generateAircraftTypes($type),
            'passenger_capacity' => $type === 'cargo_airline' ? null : $this->faker->numberBetween(150, 50000),
            'cargo_capacity' => $type === 'cargo_airline' ? $this->faker->numberBetween(100, 5000) : $this->faker->numberBetween(10, 500),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'website' => 'https://www.' . strtolower(str_replace(' ', '', $airlineName)) . '.com',
            'booking_phone' => $this->faker->phoneNumber(),
            'customer_service_phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(15, 35), // Middle East region
            'longitude' => $this->faker->longitude(25, 60), // Middle East region
            'region_id' => \App\Models\Region::inRandomOrder()->first()?->id,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id,
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id,
            'license_number' => $this->faker->bothify('AL-###-????'),
            'tax_number' => $this->faker->numerify('###########'),
            'certifications' => $this->generateCertifications(),
            'destinations' => $this->generateDestinations(),
            'services' => $this->generateServices($type),
            'cabin_classes' => $type === 'airline' ? $this->generateCabinClasses() : null,
            'has_frequent_flyer' => $type === 'airline' ? $this->faker->boolean(60) : false,
            'frequent_flyer_program' => $type === 'airline' && $this->faker->boolean(60) ? $this->generateFrequentFlyerProgram($airlineName) : null,
            'annual_revenue' => $this->faker->randomFloat(2, 50000000, 15000000000),
            'annual_passengers' => $type === 'cargo_airline' ? null : $this->faker->numberBetween(100000, 50000000),
            'on_time_performance' => $this->faker->randomFloat(2, 65.0, 95.0),
            'safety_rating' => $this->faker->randomFloat(1, 3.0, 7.0),
            'safety_rating_agency' => $this->faker->randomElement(['Skytrax', 'AirlineRatings', 'JACDEC', 'ICAO']),
            'accident_count' => $this->faker->numberBetween(0, 5),
            'last_safety_audit' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'alliance' => $type === 'airline' ? $this->faker->randomElement([null, 'Star Alliance', 'OneWorld', 'SkyTeam']) : null,
            'partnerships' => $this->generatePartnerships(),
            'codeshare_agreements' => $type === 'airline' ? $this->generateCodeshareAgreements() : null,
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'active', 'inactive', 'suspended']),
            'notes' => $this->faker->optional()->paragraph(),
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id ?? 1,
            'updated_by' => \App\Models\User::inRandomOrder()->first()?->id ?? 1,
        ];
    }

    private function generateAirlineName(): string
    {
        $prefixes = ['Royal', 'National', 'International', 'Global', 'Regional', 'Premium', 'Elite', 'Sky', 'Air', 'Gulf'];
        $suffixes = ['Airlines', 'Airways', 'Aviation', 'Express', 'Cargo', 'Charter', 'Lines'];
        $regions = ['Arabian', 'Middle East', 'Gulf', 'Levant', 'Mediterranean', 'Desert', 'Orient', 'Emirates', 'Kingdom'];

        $pattern = $this->faker->randomElement([
            '{prefix} {region} {suffix}',
            '{region} {suffix}',
            '{prefix} {suffix}',
            'Air {region}',
            '{region} Air'
        ]);

        return str_replace(
            ['{prefix}', '{suffix}', '{region}'],
            [
                $this->faker->randomElement($prefixes),
                $this->faker->randomElement($suffixes),
                $this->faker->randomElement($regions)
            ],
            $pattern
        );
    }

    private function generateAirlineCode(string $name): string
    {
        // Static array to track used codes during batch operations
        static $usedCodes = [];
        static $initialized = false;

        // Initialize with existing codes from database only once
        if (!$initialized) {
            $usedCodes = \App\Models\AirTransport::pluck('code')->toArray();
            $initialized = true;
        }

        // Generate realistic airline codes with uniqueness
        $words = explode(' ', $name);
        $baseCode = '';

        if (count($words) >= 2) {
            $baseCode = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $baseCode = strtoupper(substr($name, 0, 2));
        }

        // Check if base code is available
        if (!in_array($baseCode, $usedCodes)) {
            $usedCodes[] = $baseCode;
            return $baseCode;
        }

        // Try variations with numbers
        for ($counter = 1; $counter <= 99; $counter++) {
            $code = $baseCode . $counter;
            if (!in_array($code, $usedCodes)) {
                $usedCodes[] = $code;
                return $code;
            }
        }

        // Fallback to completely random 2-letter combinations
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < 26; $i++) {
            for ($j = 0; $j < 26; $j++) {
                $code = $letters[$i] . $letters[$j];
                if (!in_array($code, $usedCodes)) {
                    $usedCodes[] = $code;
                    return $code;
                }
            }
        }

        throw new \Exception('Unable to generate unique airline code - all combinations exhausted');
    }

    private function generateArabicName(string $englishName): string
    {
        $arabicNames = [
            'الخطوط الجوية الملكية',
            'طيران الخليج',
            'الخطوط الجوية الوطنية',
            'طيران الشرق الأوسط',
            'الخطوط الجوية العربية',
            'طيران الإمارات العربية',
            'الخطوط الجوية السعودية',
            'طيران الأردن',
            'مصر للطيران',
            'الكويتية للطيران'
        ];

        return $this->faker->randomElement($arabicNames);
    }

    private function generateArabicDescription(): string
    {
        $descriptions = [
            'شركة طيران رائدة تقدم خدمات متميزة للمسافرين في جميع أنحاء العالم',
            'إحدى أكبر شركات الطيران في المنطقة مع أسطول حديث ومتطور',
            'شركة طيران مختصة في الرحلات الإقليمية والدولية',
            'تقدم خدمات الطيران المدني والشحن الجوي',
            'شركة طيران تركز على الجودة والسلامة في خدماتها'
        ];

        return $this->faker->randomElement($descriptions);
    }

    private function generateArabicAddress(): string
    {
        $cities = ['الرياض', 'جدة', 'الدمام', 'دبي', 'الدوحة', 'الكويت', 'عمان', 'القاهرة'];
        $districts = ['حي الملك فهد', 'حي العليا', 'حي السليمانية', 'حي الشاطئ', 'المنطقة المركزية'];

        return $this->faker->randomElement($districts) . '، ' . $this->faker->randomElement($cities);
    }

    private function getServiceTypeByType(string $type): string
    {
        switch ($type) {
            case 'airline':
                return $this->faker->randomElement(['schedule', 'mixed']);
            case 'charter_company':
                return 'charter';
            case 'cargo_airline':
                return 'cargo';
            case 'aircraft_operator':
                return $this->faker->randomElement(['charter', 'private']);
            case 'aircraft_manufacturer':
                return 'schedule';
            default:
                return 'schedule';
        }
    }

    private function generateAircraftTypes(string $type): array
    {
        switch ($type) {
            case 'airline':
                $aircraftTypes = [
                    'Boeing 737',
                    'Boeing 777',
                    'Boeing 787',
                    'Airbus A320',
                    'Airbus A330',
                    'Airbus A350',
                    'Airbus A380',
                    'Boeing 747',
                    'Embraer E-Jet'
                ];
                break;
            case 'charter_company':
                $aircraftTypes = [
                    'Boeing 737',
                    'Airbus A320',
                    'Boeing 757',
                    'Airbus A319',
                    'Boeing 767'
                ];
                break;
            case 'cargo_airline':
                $aircraftTypes = [
                    'Boeing 747F',
                    'Boeing 777F',
                    'Airbus A330F',
                    'Boeing 767F',
                    'ATR 72F'
                ];
                break;
            case 'aircraft_operator':
                $aircraftTypes = [
                    'Gulfstream G650',
                    'Bombardier Global 7500',
                    'Cessna Citation',
                    'Boeing Business Jet'
                ];
                break;
            case 'aircraft_manufacturer':
                $aircraftTypes = [
                    'Boeing 737',
                    'Boeing 777',
                    'Boeing 787',
                    'Airbus A320',
                    'Airbus A330',
                    'Embraer E-Jet'
                ];
                break;
            default:
                $aircraftTypes = ['Boeing 737', 'Airbus A320'];
                break;
        }

        $count = min($this->faker->numberBetween(1, 4), count($aircraftTypes));
        return $this->faker->randomElements($aircraftTypes, $count);
    }

    private function generateCertifications(): array
    {
        $certifications = [
            'IATA Operational Safety Audit (IOSA)',
            'ICAO Compliance Certificate',
            'ISO 9001:2015 Quality Management',
            'ISAGO Ground Handling',
            'Skytrax Certification',
            'ADS-B Compliant'
        ];

        $count = min($this->faker->numberBetween(2, 4), count($certifications));
        return $this->faker->randomElements($certifications, $count);
    }

    private function generateDestinations(): array
    {
        $destinations = [
            'Riyadh (RUH)',
            'Jeddah (JED)',
            'Dubai (DXB)',
            'Doha (DOH)',
            'Kuwait (KWI)',
            'Amman (AMM)',
            'Cairo (CAI)',
            'Baghdad (BGW)',
            'Beirut (BEY)',
            'Muscat (MCT)',
            'London (LHR)',
            'Paris (CDG)',
            'Frankfurt (FRA)',
            'Istanbul (IST)',
            'New York (JFK)',
            'Mumbai (BOM)',
            'Delhi (DEL)',
            'Bangkok (BKK)',
            'Singapore (SIN)',
            'Tokyo (NRT)'
        ];

        $count = min($this->faker->numberBetween(5, 15), count($destinations));
        return $this->faker->randomElements($destinations, $count);
    }

    private function generateServices(string $type): array
    {
        $baseServices = ['Passenger Transport', 'Baggage Handling', 'Customer Service'];

        $additionalServices = match ($type) {
            'airline' => [
                'In-flight Entertainment',
                'Catering Services',
                'Wi-Fi',
                'Lounge Access',
                'Priority Boarding',
                'Extra Legroom',
                'Frequent Flyer Program'
            ],
            'charter_company' => [
                'Private Charter',
                'Group Travel',
                'Customized Itineraries',
                'VIP Services'
            ],
            'cargo_airline' => [
                'Cargo Transport',
                'Express Delivery',
                'Cold Chain',
                'Dangerous Goods',
                'Door-to-Door Service',
                'Warehousing'
            ],
            'aircraft_operator' => [
                'Private Jet Charter',
                'Aircraft Management',
                'Maintenance Services'
            ],
            default => []
        };

        $count = min($this->faker->numberBetween(2, 5), count($additionalServices));
        return array_merge($baseServices, $this->faker->randomElements($additionalServices, $count));
    }

    private function generateCabinClasses(): array
    {
        $classes = ['Economy', 'Premium Economy', 'Business', 'First Class'];
        $count = min($this->faker->numberBetween(2, 4), count($classes));
        return $this->faker->randomElements($classes, $count);
    }

    private function generateFrequentFlyerProgram(string $airlineName): string
    {
        $programNames = [
            'Miles & More',
            'SkyMiles',
            'Flying Club',
            'Executive Club',
            'Premier Club',
            'Elite Status',
            'Privilege Club'
        ];

        return $this->faker->randomElement($programNames);
    }

    private function generatePartnerships(): array
    {
        $partners = [
            'Saudi Arabian Airlines',
            'Emirates',
            'Qatar Airways',
            'Kuwait Airways',
            'Royal Jordanian',
            'EgyptAir',
            'Turkish Airlines',
            'Lufthansa',
            'British Airways',
            'Air France',
            'KLM',
            'Alitalia'
        ];

        $count = min($this->faker->numberBetween(2, 6), count($partners));
        return $this->faker->randomElements($partners, $count);
    }

    private function generateCodeshareAgreements(): array
    {
        $airlines = [
            'SV - Saudi Arabian Airlines',
            'EK - Emirates',
            'QR - Qatar Airways',
            'KU - Kuwait Airways',
            'RJ - Royal Jordanian',
            'MS - EgyptAir',
            'TK - Turkish Airlines'
        ];

        $count = min($this->faker->numberBetween(1, 4), count($airlines));
        return $this->faker->randomElements($airlines, $count);
    }

    /**
     * Create a major international airline
     */
    public function majorAirline(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'airline',
            'service_type' => 'mixed',
            'is_international' => true,
            'is_domestic' => true,
            'fleet_size' => $this->faker->numberBetween(50, 350),
            'passenger_capacity' => $this->faker->numberBetween(5000, 50000),
            'has_frequent_flyer' => true,
            'alliance' => $this->faker->randomElement(['Star Alliance', 'OneWorld', 'SkyTeam']),
            'cabin_classes' => ['Economy', 'Business', 'First Class'],
            'status' => 'active',
            'is_active' => true,
        ]);
    }

    /**
     * Create a regional airline
     */
    public function regionalAirline(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'airline',
            'service_type' => 'schedule',
            'is_international' => false,
            'is_domestic' => true,
            'fleet_size' => $this->faker->numberBetween(5, 30),
            'passenger_capacity' => $this->faker->numberBetween(500, 5000),
            'cabin_classes' => ['Economy', 'Business'],
            'alliance' => null,
        ]);
    }

    /**
     * Create a cargo airline
     */
    public function cargoAirline(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'cargo_airline',
            'service_type' => 'cargo',
            'passenger_capacity' => null,
            'cargo_capacity' => $this->faker->numberBetween(100, 5000),
            'cabin_classes' => null,
            'has_frequent_flyer' => false,
            'frequent_flyer_program' => null,
            'annual_passengers' => null,
        ]);
    }

    /**
     * Create a charter company
     */
    public function charterCompany(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'charter_company',
            'service_type' => 'charter',
            'fleet_size' => $this->faker->numberBetween(2, 20),
            'passenger_capacity' => $this->faker->numberBetween(200, 3000),
            'has_frequent_flyer' => false,
            'alliance' => null,
        ]);
    }
}