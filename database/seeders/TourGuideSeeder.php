<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\TourGuide;
use Illuminate\Database\Seeder;

class TourGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(TourGuide::class);
        RichText::where('record_type', TourGuide::class)->delete();
    }
}
