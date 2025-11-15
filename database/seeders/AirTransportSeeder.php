<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AirTransport;
use Illuminate\Support\Facades\Schema;

class AirTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AirTransport::truncate();
        Schema::enableForeignKeyConstraints();

        // Create 50 airports with realistic data
        AirTransport::factory()->count(50)->create();
    }
}