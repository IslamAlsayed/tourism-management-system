<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Currency::truncate();
        Schema::enableForeignKeyConstraints();

        Currency::insert([
            [
                'code' => 'EGP',
                'name' => 'Egyptian Pound',
                'symbol' => 'E£',
            ],
            [
                'code' => 'SPR',
                'name' => 'Saudi Riyal',
                'symbol' => 'SR',
            ],
        ]);
    }
}