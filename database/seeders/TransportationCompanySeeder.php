<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransportationCompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transportation_companies')->insert([
            [
                'name' => 'Jett Transport',
                'contact_person' => 'Omar Ali',
                'phone' => '+962799999999',
                'email' => 'info@jett.com.jo',
            ],
        ]);
    }
}
