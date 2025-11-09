<?php

namespace Database\Seeders;

use App\Models\TouristSite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TouristSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TouristSite::truncate();
        Schema::enableForeignKeyConstraints();

        // Create different types of tourist sites with specific states
        TouristSite::factory()->count(15)->active()->create(); // 15 active sites
        TouristSite::factory()->count(10)->featured()->create(); // 10 featured sites
        TouristSite::factory()->count(8)->freeEntry()->create(); // 8 free entry sites
        TouristSite::factory()->count(5)->historical()->create(); // 5 historical sites
        TouristSite::factory()->count(5)->natural()->create(); // 5 natural sites
        TouristSite::factory()->count(3)->museum()->create(); // 3 museums
        TouristSite::factory()->count(4)->create(); // 4 random sites
    }
}