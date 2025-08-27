<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('dashboard.languages', compact('languages'));
    }

    public function update(Request $request, Language $language)
    {
        $updated = $language->update(['status' => $request->status]);
        if ($updated) {
            $this->loadActiveLanguages();
            return redirect()->back()->withSuccess(__('main.messages.Updated Successfully'));
        }
        return redirect()->back()->withError(__('main.messages.Failed to update language status. Please try again.'));
    }

    public function locale($locale = 'en')
    {
        if (in_array($locale, array_keys(config('languages.languages')))) {
            $this->loadActiveLanguages();
            session()->put('locale', $locale);
            App::setLocale($locale);
            return redirect()->back()->withSuccess(__('main.messages.Change Language Successfully'));
        }

        return redirect()->back()->withError(__('main.messages.Change Language Not Successfully'));
    }

    public function loadActiveLanguages(): void
    {
        $languages = Language::where('status', 1)->pluck('name', 'code')->toArray();
        Config::set('languages.languages', $languages);
    }

    public static function isActiveLocale($locale): bool
    {
        return array_key_exists($locale, config('languages.languages'));
    }
}