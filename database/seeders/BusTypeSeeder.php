<?php

namespace Database\Seeders;

use App\Models\BusType;
use Illuminate\Database\Seeder;
use App\Models\TransportationCompany;
use Illuminate\Support\Facades\Schema;

class BusTypeSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        BusType::truncate();
        Schema::enableForeignKeyConstraints();

        $companies = TransportationCompany::all();

        foreach ($companies as $company) {
            BusType::insert([
                ['company_id' => $company->id, 'name' => 'Sedan', 'seats' => 3, 'has_ac' => true],
                ['company_id' => $company->id, 'name' => 'Mini Van', 'seats' => 7, 'has_ac' => true],
                ['company_id' => $company->id, 'name' => 'Coach Bus', 'seats' => 45, 'has_ac' => false],
                ['company_id' => $company->id, 'name' => 'Luxury Bus', 'seats' => 30, 'has_ac' => true],
            ]);
        }
    }
}