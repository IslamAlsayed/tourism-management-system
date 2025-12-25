<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\TouristSite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TouristSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * PhotoObserver will automatically create MediaFile records for all photos.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        RichText::truncate();
        TouristSite::truncate();
        Schema::enableForeignKeyConstraints();

        // Create different types of tourist sites with specific states
        TouristSite::factory()->count(15)->active()->create();
        TouristSite::factory()->count(10)->featured()->create();
        TouristSite::factory()->count(8)->freeEntry()->create();
        TouristSite::factory()->count(5)->historical()->create();
        TouristSite::factory()->count(5)->natural()->create();
        TouristSite::factory()->count(3)->museum()->create();
        TouristSite::factory()->count(4)->create();
    }
}