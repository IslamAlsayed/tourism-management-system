<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Language::truncate();

        foreach (config('languages.languages') as $key => $language) {
            Language::insert(['code' => $key, 'name' => $language, 'photo' => $key . '.svg']);
        }
    }
}