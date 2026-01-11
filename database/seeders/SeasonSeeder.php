<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Season::truncate();
        RichText::where('record_type', Season::class)->delete();
        Schema::enableForeignKeyConstraints();
    }
}