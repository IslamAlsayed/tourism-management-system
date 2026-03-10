<?php

namespace Database\Seeders;

use App\Models\RichText;
use Modules\TouristSites\Entities\TouristSite;
use Illuminate\Database\Seeder;

class TouristSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(TouristSite::class);
        RichText::where('record_type', TouristSite::class)->delete();

        // Create different types of tourist sites
        TouristSite::factory()->count(5)->active()->historical()->create();
        TouristSite::factory()->count(5)->inactive()->natural()->create();
        TouristSite::factory()->count(3)->active()->museum()->create();
        TouristSite::factory()->count(3)->inactive()->unesco()->create();
        TouristSite::factory()->count(4)->active()->create();
    }
}
