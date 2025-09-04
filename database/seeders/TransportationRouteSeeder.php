<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransportationRoute;
use Illuminate\Support\Facades\Schema;

class TransportationRouteSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        TransportationRoute::truncate();
        Schema::enableForeignKeyConstraints();

        TransportationRoute::insert([
            [
                'start_location' => 'Amman',
                'end_location' => 'Dead Sea',
            ],
            [
                'start_location' => 'Amman',
                'end_location' => 'Petra',
            ],
        ]);
    }
}