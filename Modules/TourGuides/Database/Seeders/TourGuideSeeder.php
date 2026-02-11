<?php

namespace Modules\TourGuides\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\TourGuides\Entities\TourGuide;

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
