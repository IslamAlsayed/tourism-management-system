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

        TransportationRate::insert([
            [
                'price_per_day' => fake()->randomFloat(2, 50, 200),
                'company_id' => TransportationCompany::inRandomOrder()->first()?->id ?? 1,
                'bus_type_id' => BusType::inRandomOrder()->first()?->id ?? 1,
                'route_id' => TransportationRoute::inRandomOrder()->first()?->id ?? 1,
            ],
            [
                'price_per_day' => fake()->randomFloat(2, 50, 200),
                'company_id' => TransportationCompany::inRandomOrder()->first()?->id ?? 1,
                'bus_type_id' => BusType::inRandomOrder()->first()?->id ?? 1,
                'route_id' => TransportationRoute::inRandomOrder()->first()?->id ?? 1,
            ],
        ]);
    }
}