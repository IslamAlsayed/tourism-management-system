<?php

namespace Modules\Accommodations\Database\Seeders;

use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Accommodations\Entities\Meal;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(Meal::class);
        RichText::where('record_type', Meal::class)->delete();
    }
}
