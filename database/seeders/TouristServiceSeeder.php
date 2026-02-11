<?php

namespace Database\Seeders;

use App\Models\RichText;
use Modules\Tourists\Entities\TouristService;
use Modules\Tourists\Entities\TouristSite;
use Illuminate\Database\Seeder;

class TouristServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(TouristService::class);
        RichText::where('record_type', TouristService::class)->delete();

        // Make sure we have tourist sites first
        $sites = TouristSite::count();
        if ($sites === 0) {
            TouristSite::factory()->count(10)->create();
        }

        // Create services for existing sites
        $sitesCount = TouristSite::count();

        // Create different types of services
        TouristService::factory()->count(7)->active()->create();
        TouristService::factory()->count(6)->inactive()->create();
        TouristService::factory()->count($sitesCount)->active()->create();
    }
}
