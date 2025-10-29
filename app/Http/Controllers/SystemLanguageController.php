<?php

namespace App\Http\Controllers;

use App\Models\SystemLanguage;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\SystemLanguageCreateRequest;

class SystemLanguageController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        $data = SystemLanguage::paginate(getPaginate());
        return view('pages.dashboard.system-languages.index', compact('data'));
    }

    public function create()
    {
        return view('pages.dashboard.system-languages.create');
    }

    public function store(SystemLanguageCreateRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->except('photo');
        $language = SystemLanguage::create($validated);

        if ($language) {
            $this->loadActiveLanguages();
            $this->uploadPhoto($request, $language, 'photo', "languages");
            return redirect()->route('languages.index')->with('success', __('main.messages.type_created', ['type' => __('main.language')]));
        }

        return redirect()->route('nationalities.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.language')]));
    }

    public function edit($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.language')]));
        }
        return view('pages.dashboard.system-languages.edit', compact('language'));
    }

    public function locale($locale = 'en')
    {
        if (in_array($locale, array_keys(config('languages.system_languages')))) {
            $this->loadActiveLanguages();
            session()->put('locale', $locale);
            App::setLocale($locale);
            return redirect()->back()->withSuccess(__('main.messages.change_language_successfully'));
        }

        return redirect()->back()->withError(__('main.messages.change_language_not_successfully'));
    }

    public function destroy($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.language')]));
        }
        if ($language->code == app()->getLocale()) {
            $this->locale(array_rand(config('languages.system_languages')));
        }
        $deleted = $language->delete();
        if ($deleted) {
            $this->deletePhoto($language, 'flag');
            return redirect()->route('system-languages.index')->with('success', __('main.messages.type_deleted', ['type' => __('main.language')]));
        }

        return redirect()->route('system-languages.index')->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.language')]));
    }

    public function loadActiveLanguages()
    {
        $languages = SystemLanguage::pluck('name', 'code')->toArray();
        Config::set('languages.system_languages', $languages);
    }

    public static function isActiveLocale($locale): bool
    {
        return array_key_exists($locale, config('languages.system_languages'));
    }
}