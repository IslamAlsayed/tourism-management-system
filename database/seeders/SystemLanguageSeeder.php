<?php

namespace Database\Seeders;

use App\Models\SystemLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SystemLanguageSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();

        SystemLanguage::truncate();
        foreach (config('languages.system_languages') as $key => $language) {
            SystemLanguage::updateOrCreate(['code' => $key], ['name' => $language]);
        }
    }
}