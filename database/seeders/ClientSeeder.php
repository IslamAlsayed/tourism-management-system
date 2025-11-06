<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Client::truncate();
        Schema::enableForeignKeyConstraints();

        // Create 50 clients with a mix of types
        Client::factory()->count(25)->create(); // 25 clients
        Client::factory()->count(15)->active()->create(); // 15 clients (active)
        Client::factory()->count(10)->inactive()->create(); // 15 clients (inactive)
    }
}