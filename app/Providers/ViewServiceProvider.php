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

            // Get notifications for authenticated user
            $notifications = collect();
            $unreadNotificationsCount = 0;

            if ($activeUser && class_exists(\App\Models\Notification::class)) {
                try {
                    // $notifications = \App\Models\Notification::forUser($activeUser->id)->orderBy('created_at', 'desc')->limit(10)->get();
                    $notifications = \App\Models\Notification::forUser($activeUser->id)->orderBy('created_at', 'desc')->limit(10)->paginate(getPaginate());
                    $unreadNotificationsCount = \App\Models\Notification::forUser($activeUser->id)->unread()->count();
                } catch (\Exception $e) {
                    // Handle case where notifications table doesn't exist yet
                    $notifications = collect();
                    $unreadNotificationsCount = 0;
                }
            }

            $view->with('activeUser', $activeUser);
            $view->with('system_languages', $system_languages);
            $view->with('settings', $settings);
            $view->with('notifications', $notifications);
            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        });
    }
}