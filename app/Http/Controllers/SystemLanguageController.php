<?php

namespace App\Http\Controllers;

use App\Models\SystemLanguage;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $data = array_merge($validated, $request->safe()->except('photo'));
        $language = SystemLanguage::create($data);

        if ($language) {
            $this->loadActiveLanguages();
            $this->uploadPhoto($request, $language, 'photo', "languages");
            return redirect()->route('languages.index')->withSuccess(__('messages.type_created', ['type' => __('main.language')]));
        }

        return redirect()->route('nationalities.index')->withError(__('messages.type_creation_failed', ['type' => __('main.language')]));
    }

    public function edit($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.language')]));
        }
        return view('pages.dashboard.system-languages.edit', compact('language'));
    }

    public function locale($locale = 'en')
    {
        if (in_array($locale, array_keys(config('languages.system_languages')))) {
            $this->loadActiveLanguages();
            session()->put('locale', $locale);
            App::setLocale($locale);

            // Save user's preferred locale to database
            $user = getActiveUser();
            if ($user) {
                $user->update(['preferred_language' => $locale]);
            }

            return redirect()->back()->withSuccess(__('messages.change_language_successfully'));
        }

        return redirect()->back()->withError(__('messages.change_language_not_successfully'));
    }

    public function destroy($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.language')]));
        }
        if ($language->code == app()->getLocale()) {
            $this->locale(array_rand(config('languages.system_languages')));
        }
        $deleted = $language->delete();
        if ($deleted) {
            $this->deletePhoto($language, 'flag');
            return redirect()->route('system-languages.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.language')]));
        }

        return redirect()->route('system-languages.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.language')]));
    }

    public function loadActiveLanguages()
    {
        $languages = SystemLanguage::pluck('name', 'code')->toArray();
        Config::set('languages.system_languages', $languages);
    }

    public static function isActiveLocale($locale)
    {
        return array_key_exists($locale, config('languages.system_languages'));
    }
}