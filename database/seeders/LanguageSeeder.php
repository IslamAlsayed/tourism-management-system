<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        RichText::truncate();
        Language::truncate();
        Schema::enableForeignKeyConstraints();

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