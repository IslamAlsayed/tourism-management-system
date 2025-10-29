<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransportationRate;
use App\Models\TransportationRoute;
use App\Models\TransportationCompany;
use Illuminate\Support\Facades\Schema;

class TransportationRouteSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        TransportationRoute::truncate();
        Schema::enableForeignKeyConstraints();

        TransportationRoute::insert([
            ['start_location' => 'Amman', 'end_location' => 'Dead Sea', 'distance_km' => fake()->randomFloat(2, 30, 50)],
            ['start_location' => 'Amman', 'end_location' => 'Madaba', 'distance_km' => fake()->randomFloat(2, 20, 40)],
            ['start_location' => 'Amman', 'end_location' => 'Aqaba', 'distance_km' => fake()->randomFloat(2, 300, 400)],
            ['start_location' => 'Amman', 'end_location' => 'Petra', 'distance_km' => fake()->randomFloat(2, 200, 300)],
        ]);
    }
}