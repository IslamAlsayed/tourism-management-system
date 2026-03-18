<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Modules\Localization\Http\Controllers\SystemLanguageController;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // // Check for locale in session first
        // $locale = session('locale');

        // // If no session locale, check user preference or browser preference
        // if (!$locale) {
        //     // Check if user is authenticated and has locale preference
        //     if (Auth::check() && isset(Auth::user()->preferred_language)) {
        //         $locale = Auth::user()->preferred_language;
        //     } else {
        //         // Fallback to browser locale or default
        //         $locale = $request->getPreferredLanguage(['en', 'ar']) ?? config('app.locale', 'en');
        //     }
        // }

        // // Validate locale
        // if (!in_array($locale, ['en', 'ar'])) {
        //     $locale = config('app.locale', 'en');
        // }

        // // Set application locale
        // app()->setLocale($locale);

        // // Store in session for next request
        // session(['locale' => $locale]);
        $systemLanguageController = new SystemLanguageController();
        $systemLanguageController->loadActiveLanguages();

        if (session()->has('locale')) {
            $sessLocale = session()->get('locale');
            // Check if stored language is still active or fallback
            if (SystemLanguageController::isActiveLocale($sessLocale)) {
                App::setLocale($sessLocale);
            } else {
                // Determine a fallback language if current session language is not active
                $activeLangs = config('languages.system_languages');
                if (!empty($activeLangs)) {
                    $fallback = array_key_first($activeLangs);
                    App::setLocale($fallback);
                    session()->put('locale', $fallback);
                } else {
                    App::setLocale('en'); // Absolute fallback
                }
            }
        } else {
            // No locale set, let's set a default one
            $activeLangs = config('languages.system_languages');
            if (!empty($activeLangs)) {
                $fallback = config('app.locale', 'en');
                if(!array_key_exists($fallback, $activeLangs)) {
                    $fallback = array_key_first($activeLangs);
                }
                App::setLocale($fallback);
                session()->put('locale', $fallback);
            }
        }

        return $next($request);
    }
}
