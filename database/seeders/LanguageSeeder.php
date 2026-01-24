<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        truncateWithReset(Language::class);

        if (config('languages.en_langs') && count(config('languages.en_langs')) > 0) {
            foreach (config('languages.en_langs') as $key => $language) {
                $lang = Language::updateOrCreate(['code' => $key], ['name' => $language]);
                $arabic_name = config('languages.ar_langs')[$key] ?? null;
                if ($arabic_name) {
                    $lang->update(['name_ar' => $arabic_name]);
                }
            }
        }
    }
}
