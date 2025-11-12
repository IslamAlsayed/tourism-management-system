<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Country;
use App\Models\AirTransport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AirTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AirTransport::truncate();
        Schema::enableForeignKeyConstraints();

        // Get Saudi Arabia for location context
        $saudiArabia = Country::where('name', 'Saudi Arabia')->orWhere('name_ar', 'السعودية')->first();
        $riyadhState = $saudiArabia ? State::where('country_id', $saudiArabia->id)->where('name', 'Riyadh')->first() : null;
        $makkahState = $saudiArabia ? State::where('country_id', $saudiArabia->id)->where('name', 'Makkah')->first() : null;

        // Major Middle Eastern Airlines - Real Data
        $realAirlines = [
            [
                'name' => 'Saudi Arabian Airlines',
                'name_ar' => 'الخطوط الجوية السعودية',
                'code' => 'SV',
                'description' => 'Flag carrier of Saudi Arabia, providing domestic and international flights across the globe.',
                'type' => 'airline',
                'service_type' => 'mixed',
                'is_active' => true,
                'is_international' => true,
                'is_domestic' => true,
                'established_date' => '1945-03-14',
                'hub_airport' => 'RUH',
                'fleet_size' => 144,
                'aircraft_types' => ['Boeing 777', 'Boeing 787', 'Airbus A320', 'Airbus A330', 'Boeing 737'],
                'passenger_capacity' => 35000,
                'phone' => '+966-11-454-5000',
                'email' => 'info@saudia.com',
                'website' => 'https://www.saudia.com',
                'address' => 'King Abdul Aziz International Airport',
                'city' => 'Jeddah',
                'latitude' => 21.6796,
                'longitude' => 39.1564,
                'country_id' => $saudiArabia?->id,
                'state_id' => $makkahState?->id,
                'certifications' => ['IOSA', 'ICAO Compliance', 'ISO 9001:2015'],
                'destinations' => ['London (LHR)', 'Paris (CDG)', 'New York (JFK)', 'Dubai (DXB)', 'Cairo (CAI)', 'Mumbai (BOM)'],
                'services' => ['In-flight Entertainment', 'Catering Services', 'Wi-Fi', 'Lounge Access', 'Frequent Flyer Program'],
                'cabin_classes' => ['Economy', 'Business', 'First Class'],
                'has_frequent_flyer' => true,
                'frequent_flyer_program' => 'Alfursan',
                'alliance' => 'SkyTeam',
                'safety_rating' => 6.5,
                'safety_rating_agency' => 'AirlineRatings',
                'status' => 'active',
            ],
            [
                'name' => 'Emirates',
                'name_ar' => 'طيران الإمارات',
                'code' => 'EK',
                'description' => 'Dubai-based international airline, one of the largest in the Middle East.',
                'type' => 'airline',
                'service_type' => 'schedule',
                'is_active' => true,
                'is_international' => true,
                'is_domestic' => false,
                'established_date' => '1985-03-25',
                'hub_airport' => 'DXB',
                'fleet_size' => 270,
                'aircraft_types' => ['Airbus A380', 'Boeing 777', 'Boeing 787'],
                'passenger_capacity' => 60000,
                'phone' => '+971-4-214-4444',
                'email' => 'info@emirates.com',
                'website' => 'https://www.emirates.com',
                'address' => 'Dubai International Airport',
                'city' => 'Dubai',
                'latitude' => 25.2532,
                'longitude' => 55.3657,
                'certifications' => ['IOSA', 'ICAO Compliance', 'Skytrax 5-Star'],
                'destinations' => ['London (LHR)', 'New York (JFK)', 'Sydney (SYD)', 'Tokyo (NRT)', 'Mumbai (BOM)'],
                'services' => ['ICE Entertainment', 'Gourmet Dining', 'Wi-Fi', 'Shower Spa', 'Chauffeur Service'],
                'cabin_classes' => ['Economy', 'Premium Economy', 'Business', 'First Class'],
                'has_frequent_flyer' => true,
                'frequent_flyer_program' => 'Emirates Skywards',
                'alliance' => null,
                'safety_rating' => 7.0,
                'safety_rating_agency' => 'Skytrax',
                'status' => 'active',
            ],
            [
                'name' => 'Qatar Airways',
                'name_ar' => 'الخطوط الجوية القطرية',
                'code' => 'QR',
                'description' => 'National airline of Qatar, known for luxury service and extensive network.',
                'type' => 'airline',
                'service_type' => 'schedule',
                'is_active' => true,
                'is_international' => true,
                'is_domestic' => false,
                'established_date' => '1993-11-22',
                'hub_airport' => 'DOH',
                'fleet_size' => 200,
                'aircraft_types' => ['Airbus A350', 'Boeing 777', 'Boeing 787', 'Airbus A380'],
                'passenger_capacity' => 50000,
                'phone' => '+974-4023-0000',
                'email' => 'info@qatarairways.com',
                'website' => 'https://www.qatarairways.com',
                'address' => 'Hamad International Airport',
                'city' => 'Doha',
                'latitude' => 25.2731,
                'longitude' => 51.6080,
                'certifications' => ['IOSA', 'ICAO Compliance', 'Skytrax 5-Star'],
                'destinations' => ['London (LHR)', 'Paris (CDG)', 'New York (JFK)', 'Singapore (SIN)', 'Sydney (SYD)'],
                'services' => ['Oryx Entertainment', 'Al La Carte Dining', 'Qsuite', 'Wi-Fi', 'Premium Lounge'],
                'cabin_classes' => ['Economy', 'Premium Economy', 'Business', 'First Class'],
                'has_frequent_flyer' => true,
                'frequent_flyer_program' => 'Privilege Club',
                'alliance' => 'OneWorld',
                'safety_rating' => 7.0,
                'safety_rating_agency' => 'Skytrax',
                'status' => 'active',
            ],
            [
                'name' => 'Kuwait Airways',
                'name_ar' => 'الخطوط الجوية الكويتية',
                'code' => 'KU',
                'description' => 'National carrier of Kuwait, serving destinations across the Middle East, Europe, and Asia.',
                'type' => 'airline',
                'service_type' => 'schedule',
                'is_active' => true,
                'is_international' => true,
                'is_domestic' => false,
                'established_date' => '1953-03-16',
                'hub_airport' => 'KWI',
                'fleet_size' => 31,
                'aircraft_types' => ['Boeing 777', 'Airbus A320', 'Airbus A330'],
                'passenger_capacity' => 8000,
                'phone' => '+965-171-7171',
                'email' => 'info@kuwaitairways.com',
                'website' => 'https://www.kuwaitairways.com',
                'certifications' => ['IOSA', 'ICAO Compliance'],
                'destinations' => ['London (LHR)', 'Paris (CDG)', 'Mumbai (BOM)', 'Manila (MNL)', 'Cairo (CAI)'],
                'services' => ['In-flight Entertainment', 'Catering', 'Wi-Fi'],
                'cabin_classes' => ['Economy', 'Business', 'First Class'],
                'has_frequent_flyer' => true,
                'frequent_flyer_program' => 'Oasis Club',
                'safety_rating' => 6.0,
                'status' => 'active',
            ],
            [
                'name' => 'EgyptAir',
                'name_ar' => 'مصر للطيران',
                'code' => 'MS',
                'description' => 'Flag carrier of Egypt and the oldest airline in Africa and the Arab world.',
                'type' => 'airline',
                'service_type' => 'schedule',
                'is_active' => true,
                'is_international' => true,
                'is_domestic' => true,
                'established_date' => '1932-05-07',
                'hub_airport' => 'CAI',
                'fleet_size' => 65,
                'aircraft_types' => ['Boeing 737', 'Boeing 777', 'Boeing 787', 'Airbus A320', 'Airbus A330'],
                'passenger_capacity' => 15000,
                'certifications' => ['IOSA', 'ICAO Compliance'],
                'destinations' => ['London (LHR)', 'Paris (CDG)', 'New York (JFK)', 'Jeddah (JED)', 'Dubai (DXB)'],
                'services' => ['In-flight Entertainment', 'Catering Services'],
                'cabin_classes' => ['Economy', 'Business', 'First Class'],
                'has_frequent_flyer' => true,
                'frequent_flyer_program' => 'EgyptAir Plus',
                'alliance' => 'Star Alliance',
                'safety_rating' => 5.5,
                'status' => 'active',
            ],
        ];

        // Insert real airlines data (only if not already exists)
        foreach ($realAirlines as $airlineData) {
            AirTransport::firstOrCreate(
                ['code' => $airlineData['code']], // Find by code
                $airlineData // Create with all data if not found
            );
        }

        // Generate additional test data using factory
        // Regional airlines
        AirTransport::factory()->count(5)->regionalAirline()->create();

        // Charter companies
        AirTransport::factory()->count(3)->charterCompany()->create();

        // Cargo airlines
        AirTransport::factory()->count(4)->cargoAirline()->create();

        // Additional major airlines
        AirTransport::factory()->count(8)->majorAirline()->create();
    }
}