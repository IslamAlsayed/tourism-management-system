<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $activeUser = Auth::check() ? Auth::user() : null;
            $system_languages = \App\Models\SystemLanguage::all();
            $settings = \App\Models\Setting::first();
            $view->with('activeUser', $activeUser);
            $view->with('system_languages', $system_languages);
            $view->with('settings', $settings);
        });
    }
}