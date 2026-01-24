<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Client::class);

        Client::factory()->count(5)->create(); // 5 clients
        Client::factory()->count(10)->active()->create(); // 10 clients (active)
        Client::factory()->count(15)->inactive()->create(); // 15 clients (inactive)
        $this->command->info('Seeded Clients with fake data.');
    }
}
