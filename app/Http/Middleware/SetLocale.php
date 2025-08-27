<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LanguageController;
use Symfony\Component\HttpFoundation\Response;

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
        $languageController = new LanguageController();
        $languageController->loadActiveLanguages();

        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}