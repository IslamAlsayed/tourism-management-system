<?php

namespace Database\Seeders;

use App\Models\BusType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BusTypeSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        BusType::truncate();
        Schema::enableForeignKeyConstraints();

        BusType::insert([
            [
                'company_id' => 1,
                'name' => 'Sedan',
                'seats' => 3,
            ],
            [
                'company_id' => 1,
                'name' => 'Mini Van',
                'seats' => 7,
            ],
            [
                'company_id' => 1,
                'name' => 'Coach Bus',
                'seats' => 45,
            ],
        ]);
    }
}