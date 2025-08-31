<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bus_types')->insert([
            [
                'company_id' => 1,
                'name' => 'Sedan',
                'seats' => 3,
            ],
            [
                'company_id' => 1,
                'name' => 'Mini Van',
                'seats' => 7,
            ],
            [
                'company_id' => 1,
                'name' => 'Coach Bus',
                'seats' => 45,
            ],
        ]);
    }
}
