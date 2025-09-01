<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransportationRate;
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
                'company_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'bus_type_id' => \App\Models\BusType::inRandomOrder()->first()?->id ?? 1,
                'route' => 'Amman - Petra',
                'price' => 100.00,
            ],
            [
                'company_id' => \App\Models\Hotel::inRandomOrder()->first()?->id ?? 1,
                'bus_type_id' => \App\Models\BusType::inRandomOrder()->first()?->id ?? 1,
                'route' => 'Amman - Dead Sea',
                'price' => 80.00,
            ],
        ]);
    }
}