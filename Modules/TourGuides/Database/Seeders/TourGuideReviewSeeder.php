<?php

namespace Modules\TourGuides\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\TourGuides\Entities\TourGuideReview;

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
