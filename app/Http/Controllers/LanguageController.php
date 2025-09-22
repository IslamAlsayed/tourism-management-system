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
            return redirect()->route('languages.index')->with('success', __('main.messages.created_language_successfully'));
        }

        return redirect()->route('languages.index')->with('error', __('main.messages.created_not_language_successfully'));
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
            return redirect()->route('languages.index')->with('success', __('main.messages.language_deleted_successfully'));
        }

        return redirect()->route('languages.index')->with('error', __('main.messages.language_deletion_failed'));
    }

    public function loadActiveLanguages(): void
    {
        $languages = Language::pluck('name', 'code')->toArray();
        Config::set('languages.languages', $languages);
    }

    public static function isActiveLocale($locale): bool
    {
        return array_key_exists($locale, config('languages.languages'));
    }
}