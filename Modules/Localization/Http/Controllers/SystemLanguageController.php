<?php

namespace Modules\Localization\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Modules\Localization\Entities\SystemLanguage;
use Modules\Localization\Http\Requests\SystemLanguage\StoreRequest;
use Modules\Localization\Http\Requests\SystemLanguage\UpdateRequest;

class SystemLanguageController extends Controller
{
    use PhotoUploadTrait;
    public function index()
    {
        return view('localization::system-languages.index');
    }

    public function create()
    {
        return view('localization::system-languages.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $language = SystemLanguage::create($validated);
        if ($language) {
            $this->loadActiveLanguages();
            if ($request->hasFile('photo')) {
                $this->uploadSinglePhoto($request, $language, 'photo', 'languages');
            }
            return redirect()->route('dashboard.localization.system-languages.index')->withSuccess(__('messages.type_created', ['type' => __('main.language')]));
        }
        return redirect()->route('dashboard.localization.system-languages.index')->withError(__('messages.type_creation_failed', ['type' => __('main.language')]));
    }

    public function edit($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.language')]));
        }
        return view('localization::system-languages.edit', compact('language'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.language')]));
        }
        $validated = $request->validated();
        $updated = $language->update($validated);
        if ($updated) {
            $this->loadActiveLanguages();
            if ($request->input('remove_photo') && $request->hasFile('photo')) {
                $this->uploadSinglePhoto($request, $language, 'photo', 'languages');
            }
            return redirect()->route('dashboard.localization.system-languages.index')->withSuccess(__('messages.type_updated', ['type' => __('main.language')]));
        }
        return redirect()->route('dashboard.localization.system-languages.index')->withError(__('messages.type_update_failed', ['type' => __('main.language')]));
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
            return redirect()->route('dashboard.localization.system-languages.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.language')]));
        }
        return redirect()->route('dashboard.localization.system-languages.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.language')]));
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
