<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rate;
use Illuminate\Support\Facades\Schema;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Rate::truncate();
        Schema::enableForeignKeyConstraints();
    }
}