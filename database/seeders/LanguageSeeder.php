<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        // Language::truncate();

        // foreach (config('languages.languages') as $key => $language) {
        // Language::insert(['code' => $key, 'name' => $language, 'photo' => 'languages/' . $key . '.svg']);
        // }

        foreach (config('languages.en_langs') as $key => $language) {
            Language::updateOrCreate(['code' => $key], ['name' => $language]);
        }

        // / حاول تجيب من API LibreTranslate
        // $response = Http::get('https://libretranslate.com/languages');

        // if ($response->ok()) {
        //     $languages = $response->json();

        //     foreach ($languages as $lang) {
        //         Language::updateOrCreate(['code' => $lang['code']], ['name' => $lang['name']]);
        //     }
        // } else {
        //     // fallback لو ال API مش شغال
        //     $fallback = [
        //         ['code' => 'en', 'name' => 'English'],
        //         ['code' => 'ar', 'name' => 'Arabic'],
        //         ['code' => 'fr', 'name' => 'French'],
        //         ['code' => 'es', 'name' => 'Spanish'],
        //     ];

        //     foreach ($fallback as $lang) {
        //         Language::updateOrCreate($lang);
        //     }
        // }
    }
}