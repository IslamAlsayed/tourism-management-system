<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusType;
use App\Models\TransportationCompany;
use App\Models\TransportationRate;
use App\Models\TransportationRoute;
use Illuminate\Support\Facades\Schema;

class TransportationRateSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TransportationRate::truncate();
        Schema::enableForeignKeyConstraints();

        $companies = TransportationCompany::all();
        $routes = TransportationRoute::all();

        foreach ($companies as $company) {
            $busTypes = $company->busTypes; // كل أنواع الحافلات الخاصة بالشركة

            foreach ($busTypes as $busType) {
                foreach ($routes as $route) {
                    TransportationRate::create([
                        'company_id' => $company->id,
                        'bus_type_id' => $busType->id,
                        'route_id' => $route->id,
                        'price_per_day' => fake()->randomFloat(2, 50, 200),
                        'price_per_km' => fake()->randomFloat(2, 0.5, 5),
                    ]);
                }
            }
        }
    }
}