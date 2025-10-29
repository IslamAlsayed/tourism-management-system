<?php

namespace Database\Seeders;

use App\Models\TourGuide;
use App\Models\TourGuideType;
use App\Models\TourGuideReview;
use Illuminate\Database\Seeder;
use App\Models\TourGuideLanguage;
use Illuminate\Support\Facades\Schema;

class TourGuideSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // TourGuide::truncate();
        // TourGuideType::truncate();
        TourGuideReview::truncate();
        // TourGuideLanguage::truncate();
        Schema::enableForeignKeyConstraints();
    }
}