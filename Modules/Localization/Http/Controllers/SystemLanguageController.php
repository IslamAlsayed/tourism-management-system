<?php

namespace Modules\Localization\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Modules\Localization\Entities\SystemLanguage;
use Modules\Localization\Http\Requests\SystemLanguageStoreRequest;
use Modules\Localization\Http\Requests\SystemLanguageUpdateRequest;

class SystemLanguageController extends Controller
{
    use PhotoUploadTrait;
    public function index()
    {
        return view('localization::system-languages.index');
    }

    public function create()
    {
        $flags = \Illuminate\Support\Facades\File::exists(public_path('assets/media/flags')) ? array_map('basename', \Illuminate\Support\Facades\File::files(public_path('assets/media/flags'))) : [];
        return view('localization::system-languages.create', compact('flags'));
    }

    public function store(SystemLanguageStoreRequest $request)
    {
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except(['photo', 'selected_flag']));
        $language = SystemLanguage::create($data);
        if ($language) {
            $this->loadActiveLanguages();
            
            if ($request->hasFile('photo')) {
                $this->uploadPhoto($request, $language, 'photo', "languages");
            } elseif ($request->filled('selected_flag')) {
                $source = public_path('assets/media/flags/' . $request->selected_flag);
                if (file_exists($source)) {
                    $destPath = 'languages/' . time() . '_' . $request->selected_flag;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($destPath, file_get_contents($source));
                    $language->update(['photo' => $destPath]);
                }
            }

            return redirect()->route('dashboard.localization.system-languages.index')->with('success', __('messages.type_created', ['type' => __('main.language')]));
        }
        return redirect()->route('dashboard.localization.system-languages.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.language')]));
    }

    public function edit($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.language')]));
        }
        $flags = \Illuminate\Support\Facades\File::exists(public_path('assets/media/flags')) ? array_map('basename', \Illuminate\Support\Facades\File::files(public_path('assets/media/flags'))) : [];
        return view('localization::system-languages.edit', compact('language', 'flags'));
    }

    public function update(SystemLanguageUpdateRequest $request, $id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.language')]));
        }

        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except(['photo', 'selected_flag']));
        
        $updated = $language->update($data);
        if ($updated) {
            $this->loadActiveLanguages();
            if ($request->hasFile('photo')) {
                $this->uploadPhoto($request, $language, 'photo', "languages");
            } elseif ($request->filled('selected_flag')) {
                $source = public_path('assets/media/flags/' . $request->selected_flag);
                if (file_exists($source)) {
                    $destPath = 'languages/' . time() . '_' . $request->selected_flag;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($destPath, file_get_contents($source));
                    $this->deletePhoto($language, 'photo');
                    $language->update(['photo' => $destPath]);
                }
            }
            return redirect()->route('dashboard.localization.system-languages.index')->with('success', __('messages.type_updated', ['type' => __('main.language')]));
        }
        return redirect()->route('dashboard.localization.system-languages.index')->with('error', __('messages.type_update_failed', ['type' => __('main.language')]));
    }

    public function show($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.language')]));
        }
        
        // Use the existing edit view but we can create a dedicated show view later if needed. For now just passing to show view.
        return view('localization::system-languages.show', compact('language'));
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
            return redirect()->back()->with('success', __('messages.change_language_successfully'));
        }
        return redirect()->back()->with('error', __('messages.change_language_not_successfully'));
    }

    public function destroy($id)
    {
        $language = SystemLanguage::find($id);
        if (!$language) {
            return redirect()->back()->with('error', __('messages.not_found_this_type', ['type' => __('main.language')]));
        }
        if ($language->code == app()->getLocale()) {
            $this->locale(array_rand(config('languages.system_languages')));
        }
        $deleted = $language->delete();
        if ($deleted) {
            $this->deletePhoto($language, 'flag');
            return redirect()->route('dashboard.localization.system-languages.index')->with('success', __('messages.type_deleted', ['type' => __('main.language')]));
        }
        return redirect()->route('dashboard.localization.system-languages.index')->with('error', __('messages.type_deletion_failed', ['type' => __('main.language')]));
    }

    public function loadActiveLanguages()
    {
        $languages = SystemLanguage::where('is_active', 1)->get()->keyBy('code')->map(function($lang) {
            return [
                'name' => $lang->name,
                'native' => $lang->native,
                'dir' => $lang->dir,
            ];
        })->toArray();
        Config::set('languages.system_languages', $languages);
    }

    public static function isActiveLocale($locale)
    {
        return array_key_exists($locale, config('languages.system_languages'));
    }
}
