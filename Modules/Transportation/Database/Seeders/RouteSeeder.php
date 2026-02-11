<?php

namespace Modules\Transportation\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Geography\Entities\City;
use Modules\Transportation\Entities\Route;
use Modules\Localization\Entities\Currency;
use Modules\Transportation\Entities\Company;
use Modules\Transportation\Entities\VehicleType;
use Modules\Transportation\Entities\RouteAssignment;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // حذف البيانات القديمة
        truncateWithReset(Route::class);
        RichText::where('record_type', Route::class)->delete();

        truncateWithReset(RouteAssignment::class);
        RichText::where('record_type', RouteAssignment::class)->delete();

        // جلب المدن المطلوبة
        $cairo = City::where('name', 'Cairo')->first();
        $alexandria = City::where('name', 'Alexandria')->first();
        $luxor = City::where('name', 'Luxor')->first();
        $aswan = City::where('name', 'Aswan')->first();
        $sharmElSheikh = City::where('name', 'Sharm El Sheikh')->first();
        $hurghada = City::where('name', 'Hurghada')->first();
        $amman = City::where('name', 'Amman')->first();
        $petra = City::where('name', 'Petra')->first();
        $aqaba = City::where('name', 'Aqaba')->first();

        // المسارات المصرية
        $egyptRoutes = [
            [
                'name' => 'Cairo to Alexandria',
                'name_ar' => 'القاهرة إلى الإسكندرية',
                'code' => 'CAI-ALX-001',
                'origin_city_id' => $cairo?->id,
                'origin_address' => 'Cairo Airport',
                'origin_latitude' => 30.0444,
                'origin_longitude' => 31.2357,
                'destination_city_id' => $alexandria?->id,
                'destination_address' => 'Alexandria Train Station',
                'destination_latitude' => 31.2001,
                'destination_longitude' => 29.9187,
                'distance' => 220.5,
                'estimated_duration' => 180, // 3 hours
                'route_type' => 'one_way',
                'is_toll_road' => true,
                'toll_fee' => 50.00,
                'road_condition' => 'excellent',
                'is_active' => true,
            ],
            [
                'name' => 'Cairo to Luxor',
                'name_ar' => 'القاهرة إلى الأقصر',
                'code' => 'CAI-LUX-001',
                'origin_city_id' => $cairo?->id,
                'origin_address' => 'Cairo Downtown',
                'origin_latitude' => 30.0444,
                'origin_longitude' => 31.2357,
                'destination_city_id' => $luxor?->id,
                'destination_address' => 'Luxor Temple',
                'destination_latitude' => 25.6872,
                'destination_longitude' => 32.6396,
                'distance' => 670.0,
                'estimated_duration' => 600, // 10 hours
                'route_type' => 'one_way',
                'is_toll_road' => false,
                'road_condition' => 'good',
                'is_active' => true,
            ],
            [
                'name' => 'Cairo to Sharm El Sheikh',
                'name_ar' => 'القاهرة إلى شرم الشيخ',
                'code' => 'CAI-SSH-001',
                'origin_city_id' => $cairo?->id,
                'origin_address' => 'Cairo City Center',
                'destination_city_id' => $sharmElSheikh?->id,
                'destination_address' => 'Sharm El Sheikh Marina',
                'distance' => 480.0,
                'estimated_duration' => 390, // 6.5 hours
                'route_type' => 'round_trip',
                'is_toll_road' => true,
                'toll_fee' => 75.00,
                'road_condition' => 'excellent',
                'is_active' => true,
            ],
            [
                'name' => 'Cairo to Hurghada',
                'name_ar' => 'القاهرة إلى الغردقة',
                'code' => 'CAI-HRG-001',
                'origin_city_id' => $cairo?->id,
                'destination_city_id' => $hurghada?->id,
                'destination_address' => 'Hurghada Marina',
                'distance' => 450.0,
                'estimated_duration' => 360, // 6 hours
                'route_type' => 'round_trip',
                'is_toll_road' => true,
                'toll_fee' => 60.00,
                'road_condition' => 'excellent',
                'is_active' => true,
            ],
            [
                'name' => 'Luxor to Aswan',
                'name_ar' => 'الأقصر إلى أسوان',
                'code' => 'LUX-ASW-001',
                'origin_city_id' => $luxor?->id,
                'origin_address' => 'Luxor Temple',
                'destination_city_id' => $aswan?->id,
                'destination_address' => 'Aswan High Dam',
                'distance' => 230.0,
                'estimated_duration' => 210, // 3.5 hours
                'route_type' => 'one_way',
                'is_toll_road' => false,
                'road_condition' => 'good',
                'is_active' => true,
            ],
        ];

        // المسارات الأردنية
        $jordanRoutes = [
            [
                'name' => 'Amman to Petra',
                'name_ar' => 'عمان إلى البتراء',
                'code' => 'AMM-PTR-001',
                'origin_city_id' => $amman?->id,
                'origin_address' => 'Amman City Center',
                'destination_city_id' => $petra?->id,
                'destination_address' => 'Petra Visitor Center',
                'distance' => 235.0,
                'estimated_duration' => 180, // 3 hours
                'route_type' => 'round_trip',
                'is_toll_road' => false,
                'road_condition' => 'good',
                'is_active' => true,
            ],
            [
                'name' => 'Amman to Aqaba',
                'name_ar' => 'عمان إلى العقبة',
                'code' => 'AMM-AQB-001',
                'origin_city_id' => $amman?->id,
                'origin_address' => 'Queen Alia Airport',
                'destination_city_id' => $aqaba?->id,
                'destination_address' => 'Aqaba Port',
                'distance' => 330.0,
                'estimated_duration' => 240, // 4 hours
                'route_type' => 'one_way',
                'is_toll_road' => false,
                'road_condition' => 'excellent',
                'is_active' => true,
            ],
            [
                'name' => 'Petra to Aqaba',
                'name_ar' => 'البتراء إلى العقبة',
                'code' => 'PTR-AQB-001',
                'origin_city_id' => $petra?->id,
                'destination_city_id' => $aqaba?->id,
                'destination_address' => 'Aqaba Beach',
                'distance' => 125.0,
                'estimated_duration' => 120, // 2 hours
                'route_type' => 'one_way',
                'is_toll_road' => false,
                'road_condition' => 'good',
                'is_active' => true,
            ],
        ];

        // دمج جميع المسارات
        $allRoutes = array_merge($egyptRoutes, $jordanRoutes);

        // إنشاء المسارات
        foreach ($allRoutes as $routeData) {
            if (isset($routeData['origin_city_id']) && isset($routeData['destination_city_id'])) {
                $route = Route::create($routeData);
                $this->command->info("Created route: {$route->name}");

                // إنشاء تعيينات للمسار (ربط بشركات ومركبات)
                $this->createRouteAssignments($route);
            }
        }
    }

    /**
     * Create route assignments for a given route
     */
    private function createRouteAssignments($route)
    {
        // جلب الشركات والمركبات
        $companies = Company::where('is_active', true)->limit(3)->get();
        $currency = Currency::where('code', 'EGP')->first() ?? Currency::first();

        foreach ($companies as $company) {
            // جلب أنواع المركبات للشركة
            $vehicleTypes = VehicleType::where('company_id', $company->id)->where('is_active', true)->limit(2)->get();

            if ($vehicleTypes->isEmpty()) {
                $vehicleTypes = VehicleType::where('is_active', true)->limit(2)->get();
            }

            foreach ($vehicleTypes as $vehicleType) {
                // حساب السعر بناءً على المسافة ونوع المركبة
                $basePrice = $this->calculatePrice($route->distance, $vehicleType);

                RouteAssignment::create([
                    'route_id' => $route->id,
                    'company_id' => $company->id,
                    'vehicle_type_id' => $vehicleType->id,
                    'currency_id' => $currency->id,
                    'base_price' => $basePrice,
                    'price_per_km' => round($basePrice / $route->distance, 2),
                    'price_per_person' => round($basePrice / $vehicleType->max_capacity, 2),
                    'available_days' => fake()->randomElements([0, 1, 2, 3, 4, 5, 6], fake()->numberBetween(4, 6)),
                    'departure_time' => '08:00:00',
                    'arrival_time' => $this->calculateArrivalTime('08:00:00', $route->estimated_duration),
                    'frequency_per_day' => rand(1, 3),
                    'is_active' => true,
                    'valid_from' => now(),
                    'valid_to' => now()->addYear(),
                ]);
                $this->command->info("Created assignment for route {$route->name} with company {$company->name} and vehicle type {$vehicleType->name}.");
            }
        }
    }

    /**
     * Calculate price based on distance and vehicle type
     */
    private function calculatePrice($distance, $vehicleType)
    {
        // سعر أساسي بناءً على سعة المركبة
        $baseRate = match (true) {
            $vehicleType->max_capacity <= 4 => 2.5,  // Limousine
            $vehicleType->max_capacity <= 12 => 4.0, // Van/Microbus
            $vehicleType->max_capacity <= 25 => 6.0, // Small bus
            default => 8.0, // Large bus
        };

        // حساب السعر الإجمالي
        $totalPrice = $distance * $baseRate * $vehicleType->max_capacity * 0.5;

        // إضافة رسوم الطريق إن وجدت
        if ($distance > 300) {
            $totalPrice += 100; // رسوم إضافية للمسافات الطويلة
        }

        return round($totalPrice, 2);
    }

    /**
     * Calculate arrival time based on departure time and duration
     */
    private function calculateArrivalTime($departureTime, $durationInMinutes)
    {
        $departure = \Carbon\Carbon::createFromFormat('H:i:s', $departureTime);
        $arrival = $departure->addMinutes($durationInMinutes);
        return $arrival->format('H:i:s');
    }
}
