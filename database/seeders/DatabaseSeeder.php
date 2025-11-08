<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            SystemLanguageSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            ClientSeeder::class,
        ]);
    }
}