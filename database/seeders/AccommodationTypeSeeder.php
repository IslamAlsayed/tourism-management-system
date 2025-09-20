<?php

namespace Database\Seeders;

use App\Models\AccommodationType;
use Illuminate\Database\Seeder;
use App\Models\Accommodation;
use Illuminate\Support\Facades\Schema;

class AccommodationTypeSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AccommodationType::truncate();
        Schema::enableForeignKeyConstraints();
    }
}