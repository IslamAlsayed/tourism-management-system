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

        // Create 50 airports with realistic data
        Airline::factory()->count(50)->create();
    }
}