<?php

namespace Database\Seeders;

use App\Models\CrossingPort;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CrossingPortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CrossingPort::truncate();
        Schema::enableForeignKeyConstraints();

        // Create specific crossing ports and airports
        CrossingPort::factory()->internationalAirport()->count(5)->create();
        CrossingPort::factory()->domesticAirport()->count(5)->create();
        CrossingPort::factory()->seaport()->count(3)->create();
        CrossingPort::factory()->landCrossing()->count(7)->create();

        // Create additional random crossing ports
        CrossingPort::factory()->count(10)->create();

        // Create some sample real crossing ports
        $this->createRealCrossingPorts();
    }

    /**
     * Create some real crossing ports for better seeding
     */
    private function createRealCrossingPorts(): void
    {
        $realCrossingPorts = [
            [
                'code' => 'RUH',
                'name' => 'King Khalid International Airport',
                'name_ar' => 'مطار الملك خالد الدولي',
                'type' => 'international_airport',
                'description' => 'The main international airport serving Riyadh, Saudi Arabia',
                'description_ar' => 'المطار الدولي الرئيسي الذي يخدم الرياض، المملكة العربية السعودية',
                'latitude' => 24.9576,
                'longitude' => 46.6988,
                'elevation' => '2049 ft',
                'is_operational' => true,
                'is_24_hours' => true,
                'status' => 'active',
                'capacity' => 2500,
                'phone' => '+966 11 221 1000',
                'website' => 'https://www.riyadhairport.com',
                'address' => 'King Khalid International Airport, Riyadh 13455',
                'address_ar' => 'مطار الملك خالد الدولي، الرياض 13455',
                'facilities' => ['customs', 'immigration', 'duty_free', 'vip_lounge', 'restaurants', 'currency_exchange'],
                'services' => ['baggage_handling', 'ground_services', 'fueling'],
                'runway_info' => [
                    'length' => '4000m',
                    'width' => '60m',
                    'surface' => 'asphalt',
                    'lighting' => true
                ]
            ],
            [
                'code' => 'JED',
                'name' => 'King Abdulaziz International Airport',
                'name_ar' => 'مطار الملك عبدالعزيز الدولي',
                'type' => 'international_airport',
                'description' => 'The main international airport serving Jeddah, Saudi Arabia',
                'description_ar' => 'المطار الدولي الرئيسي الذي يخدم جدة، المملكة العربية السعودية',
                'latitude' => 21.6796,
                'longitude' => 39.1565,
                'elevation' => '48 ft',
                'is_operational' => true,
                'is_24_hours' => true,
                'status' => 'active',
                'capacity' => 3000,
                'phone' => '+966 12 684 2222',
                'website' => 'https://www.jeddahairport.com',
                'address' => 'King Abdulaziz International Airport, Jeddah 23631',
                'address_ar' => 'مطار الملك عبدالعزيز الدولي، جدة 23631',
                'facilities' => ['customs', 'immigration', 'duty_free', 'vip_lounge', 'restaurants', 'currency_exchange'],
                'services' => ['baggage_handling', 'ground_services', 'fueling'],
                'runway_info' => [
                    'length' => '4000m',
                    'width' => '60m',
                    'surface' => 'asphalt',
                    'lighting' => true
                ]
            ],
            [
                'code' => 'JIP',
                'name' => 'Jeddah Islamic Port',
                'name_ar' => 'ميناء جدة الإسلامي',
                'type' => 'seaport',
                'description' => 'Major seaport on the Red Sea serving western Saudi Arabia',
                'description_ar' => 'ميناء بحري رئيسي على البحر الأحمر يخدم غرب المملكة العربية السعودية',
                'latitude' => 21.4858,
                'longitude' => 39.1925,
                'is_operational' => true,
                'is_24_hours' => true,
                'status' => 'active',
                'capacity' => 5000,
                'phone' => '+966 12 603 4444',
                'website' => 'https://www.ports.gov.sa',
                'address' => 'Jeddah Islamic Port, Jeddah',
                'address_ar' => 'ميناء جدة الإسلامي، جدة',
                'facilities' => ['customs', 'immigration', 'cargo_handling', 'passenger_terminal', 'parking'],
                'services' => ['cargo_services', 'passenger_services', 'ship_services']
            ],
            [
                'code' => 'ALB',
                'name' => 'Al-Batha Border Crossing',
                'name_ar' => 'معبر البطحاء الحدودي',
                'type' => 'land_crossing',
                'description' => 'Major land border crossing between Saudi Arabia and UAE',
                'description_ar' => 'معبر حدودي بري رئيسي بين المملكة العربية السعودية والإمارات العربية المتحدة',
                'latitude' => 24.0000,
                'longitude' => 51.6000,
                'is_operational' => true,
                'is_24_hours' => true,
                'status' => 'active',
                'capacity' => 1000,
                'phone' => '+966 13 123 4567',
                'address' => 'Al-Batha Border Crossing, Eastern Province',
                'address_ar' => 'معبر البطحاء الحدودي، المنطقة الشرقية',
                'facilities' => ['customs', 'immigration', 'security'],
                'services' => ['inspection_services', 'document_processing']
            ]
        ];

        foreach ($realCrossingPorts as $crossingPort) {
            CrossingPort::create(array_merge($crossingPort, [
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}