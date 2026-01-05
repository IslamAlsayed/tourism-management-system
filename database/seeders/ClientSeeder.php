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

        Client::factory()->count(5)->create(); // 5 clients
        Client::factory()->count(10)->active()->create(); // 10 clients (active)
        Client::factory()->count(15)->inactive()->create(); // 15 clients (inactive)
    }
}