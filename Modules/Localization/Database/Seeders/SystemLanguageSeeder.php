<?php

namespace Modules\Localization\Database\Seeders;

use Modules\Localization\Entities\SystemLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SystemLanguageSeeder extends Seeder
{
    public function run(): void
    {
        truncateWithReset(SystemLanguage::class);
        foreach (config('languages.system_languages') as $key => $language) {
            SystemLanguage::updateOrCreate(['code' => $key], ['name' => $language]);
        }
    }
}
