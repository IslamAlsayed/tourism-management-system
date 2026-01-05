<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Airline::truncate();
        Schema::enableForeignKeyConstraints();

        Airline::factory()->count(10)->create();
    }
}