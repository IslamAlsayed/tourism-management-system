<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accommodation;
use Illuminate\Support\Facades\Schema;

class AccommodationSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Accommodation::truncate();
        Schema::enableForeignKeyConstraints();
    }
}