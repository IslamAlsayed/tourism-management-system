<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransportationRateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transportation_rates')->insert([
            [
                'company_id' => 1,
                'bus_type_id' => 1,
                'route' => 'Amman - Petra',
                'price' => 100.00,
            ],
            [
                'company_id' => 1,
                'bus_type_id' => 2,
                'route' => 'Amman - Dead Sea',
                'price' => 80.00,
            ],
        ]);
    }
}
