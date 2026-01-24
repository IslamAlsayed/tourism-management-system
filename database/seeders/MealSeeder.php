<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\RichText;
use Illuminate\Database\Seeder;

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
