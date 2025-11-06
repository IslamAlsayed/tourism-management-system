<?php

namespace Database\Seeders;

use App\Models\SystemLanguage;
use Illuminate\Database\Seeder;

class SystemLanguageSeeder extends Seeder
{
    public function run(): void
    {
        SystemLanguage::truncate();

        foreach (config('languages.system_languages') as $key => $language) {
            SystemLanguage::updateOrCreate(['code' => $key], ['name' => $language]);
        }
    }
}