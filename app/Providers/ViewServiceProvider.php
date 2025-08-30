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
            $languages = \App\Models\Language::all();
            $view->with('activeUser', $activeUser);
            $view->with('languages', $languages);
        });
    }
}