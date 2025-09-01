<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SiteSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Site::truncate();
        Schema::enableForeignKeyConstraints();

        Site::insert([
            [
                'name_ar' => 'البتراء',
                'name_en' => 'Petra',
                'entry_fee' => 50.00,
                'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? 1,
                'city' => 'Petra',
            ],
            [
                'name_ar' => 'جرش',
                'name_en' => 'Jerash',
                'entry_fee' => 10.00,
                'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id ?? 1,
                'city' => 'Jerash',
            ]
        ]);
    }
}