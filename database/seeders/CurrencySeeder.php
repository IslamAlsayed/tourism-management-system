<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::truncate();

        DB::table('currencies')->insert(values: [
            [
                'code' => 'JOD',
                'name' => 'Jordanian Dinar',
                'symbol' => 'JD',
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
            ],
        ]);
    }
}
