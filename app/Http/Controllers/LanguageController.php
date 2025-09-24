<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\CreateLanguageRequest;

class LanguageController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        $data = Language::paginate(getPaginate());
        return view('pages.dashboard.languages.index', compact('data'));
    }

    public function create()
    {
        return view('pages.dashboard.languages.create');
    }

    public function store(CreateLanguageRequest $request)
    {
        $language = Language::create($request->validated());

        if ($language) {
            $this->loadActiveLanguages();
            $this->uploadPhoto($request, $language, 'flag', "languages");
            return redirect()->route('languages.index')->with('success', __('main.messages.type_created', ['type' => __('main.language')]));
        }

        return redirect()->route('nationalities.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.language')]));
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('pages.dashboard.languages.edit', compact('language'));
    }

    public function locale($locale = 'en')
    {
        if (in_array($locale, array_keys(config('languages.languages')))) {
            $this->loadActiveLanguages();
            session()->put('locale', $locale);
            App::setLocale($locale);
            return redirect()->back()->withSuccess(__('main.messages.change_language_successfully'));
        }

        return redirect()->back()->withError(__('main.messages.change_language_not_successfully'));
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        if ($language->code == app()->getLocale()) {
            $this->locale(array_rand(config('languages.languages')));
        }
        $deleted = $language->delete();
        if ($deleted) {
            $this->deletePhoto($language, 'flag');
            return redirect()->route('nationalities.index')->with('success', __('main.messages.type_deleted', ['type' => __('main.language')]));
        }

        return redirect()->route('nationalities.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.language')]));
    }

    public function loadActiveLanguages()
    {
        $languages = Language::pluck('name', 'code')->toArray();
        Config::set('languages.languages', $languages);
    }

    public static function isActiveLocale($locale): bool
    {
        return array_key_exists($locale, config('languages.languages'));
    }
}