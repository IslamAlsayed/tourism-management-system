<?php

namespace Database\Seeders;

use App\Models\TouristService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TouristServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * PhotoObserver will automatically create MediaFile records for all photos.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TouristService::truncate();
        Schema::enableForeignKeyConstraints();

        // Create different types of tourist sites with specific states
        TouristService::factory()->count(5)->active()->create();
        TouristService::factory()->count(5)->featured()->create();
        TouristService::factory()->count(5)->freeEntry()->create();
        TouristService::factory()->count(5)->historical()->create();
        TouristService::factory()->count(5)->natural()->create();
        TouristService::factory()->count(3)->museum()->create();
        TouristService::factory()->count(4)->create();
    }
}