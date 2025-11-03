<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 clients with a mix of types
        // 30 individual clients
        Client::factory()
            ->count(30)
            ->individual()
            ->create();

        // 15 corporate clients (active and verified)
        Client::factory()
            ->count(15)
            ->corporate()
            ->active()
            ->verified()
            ->create();

        // 5 additional corporate clients (random status)
        Client::factory()
            ->count(5)
            ->corporate()
            ->create();

        $this->command->info('50 clients created successfully!');
        $this->command->info('- 30 individual clients');
        $this->command->info('- 20 corporate clients');
    }
}
