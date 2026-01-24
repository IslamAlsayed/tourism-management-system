<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\TourGuideReview;
use Illuminate\Database\Seeder;

class TourGuideReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(TourGuideReview::class);
        RichText::where('record_type', TourGuideReview::class)->delete();
    }
}
