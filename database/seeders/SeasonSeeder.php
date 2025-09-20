<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SeasonSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Season::truncate();
        Schema::enableForeignKeyConstraints();
    }
}