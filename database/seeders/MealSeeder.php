<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Meal::truncate();
        RichText::where('record_type', Meal::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}