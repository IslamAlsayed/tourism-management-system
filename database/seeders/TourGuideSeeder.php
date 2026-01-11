<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\TourGuide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TourGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        TourGuide::truncate();
        RichText::where('record_type', TourGuide::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}