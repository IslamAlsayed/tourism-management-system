<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Notification;
use App\Models\SystemLanguage;
use Illuminate\Support\Facades\Log;
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
            $system_languages = SystemLanguage::all();
            $settings = Setting::first() ?? null;

            // Get notifications for authenticated user
            $notifications = collect();
            // $unreadNotificationsCount = 0;

            // if ($activeUser && class_exists(Notification::class)) {
            //     try {
            //         $notifications = Notification::targetMe($activeUser->id)->orderBy('created_at', 'desc')->limit(10)->get();
            //         $unreadNotificationsCount = Notification::targetMe($activeUser->id)->unread()->count();
            //     } catch (\Exception $e) {
            //         Log::error('Error fetching notifications: ' . $e->getMessage());
            //         $notifications = collect();
            //         $unreadNotificationsCount = 0;
            //     }
            // }

            $view->with('activeUser', $activeUser);
            $view->with('system_languages', $system_languages);
            $view->with('settings', $settings);
            // $view->with('notifications', $notifications);
            // $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        });
    }
}