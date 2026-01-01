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
                'latitude' => 24.9576,
                'longitude' => 46.6988,
                'operating_hours' => '24 Hours',
                'is_24_7' => true,
                'is_active' => true,
                'is_commercial' => true,
                'is_passenger' => true,
                'is_international' => true,
                'is_major' => true,
                'allows_visa_on_arrival' => true,
                'departure_tax' => 75.00,
                'departure_tax_currency_id' => \App\Models\Currency::where('code', 'SAR')->first()?->id,
                'contact_phone' => '+966 11 221 1000',
                'website' => 'https://www.riyadhairport.com',
                'visa_required' => false,
                'sort_order' => 1,
                'nationality_policy' => [
                    'US' => 'visa_on_arrival',
                    'UK' => 'visa_on_arrival',
                    'EU' => 'visa_on_arrival',
                    'GCC' => 'visa_free'
                ]
            ],
            [
                'code' => 'JED',
                'name' => 'King Abdulaziz International Airport',
                'name_ar' => 'مطار الملك عبدالعزيز الدولي',
                'type' => 'international_airport',
                'description' => 'The main international airport serving Jeddah, Saudi Arabia',
                'latitude' => 21.6796,
                'longitude' => 39.1565,
                'operating_hours' => '24 Hours',
                'is_24_7' => true,
                'is_active' => true,
                'is_commercial' => true,
                'is_passenger' => true,
                'is_international' => true,
                'is_major' => true,
                'allows_visa_on_arrival' => true,
                'departure_tax' => 75.00,
                'departure_tax_currency_id' => \App\Models\Currency::where('code', 'SAR')->first()?->id,
                'contact_phone' => '+966 12 684 2222',
                'website' => 'https://www.jeddahairport.com',
                'visa_required' => false,
                'sort_order' => 2,
                'nationality_policy' => [
                    'US' => 'visa_on_arrival',
                    'UK' => 'visa_on_arrival',
                    'EU' => 'visa_on_arrival',
                    'GCC' => 'visa_free'
                ]
            ],
            [
                'code' => 'JIP',
                'name' => 'Jeddah Islamic Port',
                'name_ar' => 'ميناء جدة الإسلامي',
                'type' => 'seaport',
                'description' => 'Major seaport on the Red Sea serving western Saudi Arabia',
                'latitude' => 21.4858,
                'longitude' => 39.1925,
                'operating_hours' => '24 Hours',
                'is_24_7' => true,
                'is_active' => true,
                'is_commercial' => true,
                'is_passenger' => true,
                'is_international' => true,
                'is_major' => true,
                'allows_visa_on_arrival' => false,
                'contact_phone' => '+966 12 603 4444',
                'website' => 'https://www.ports.gov.sa',
                'visa_required' => true,
                'sort_order' => 3
            ],
            [
                'code' => 'ALB',
                'name' => 'Al-Batha Border Crossing',
                'name_ar' => 'معبر البطحاء الحدودي',
                'type' => 'land_crossing',
                'description' => 'Major land border crossing between Saudi Arabia and UAE',
                'latitude' => 24.0000,
                'longitude' => 51.6000,
                'operating_hours' => '06:00 - 22:00',
                'is_24_7' => false,
                'is_active' => true,
                'is_commercial' => false,
                'is_passenger' => true,
                'is_international' => true,
                'is_major' => false,
                'allows_visa_on_arrival' => false,
                'contact_phone' => '+966 13 123 4567',
                'visa_required' => true,
                'sort_order' => 4
            ]
        ];

        foreach ($realCrossingPorts as $crossingPort) {
            CrossingPort::create($crossingPort);
        }
    }
}