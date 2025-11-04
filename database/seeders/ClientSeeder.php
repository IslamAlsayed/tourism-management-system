<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // 25 clients
        Client::factory()->count(25)->create();

        // 15 clients (active)
        Client::factory()->count(15)->active()->create();

        // 15 clients (inactive)
        Client::factory()->count(10)->inactive()->create();

        $this->command->info('50 clients created successfully!');
        $this->command->info('- 25 clients (random)');
        $this->command->info('- 15 clients (active)');
        $this->command->info('- 10 clients (inactive)');
    }
}