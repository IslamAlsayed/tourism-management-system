<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Client;
use App\Models\Airline;
use App\Models\Country;
use App\Models\Setting;
use App\Models\MediaFile;
use App\Models\TourGuide;
use App\Models\Restaurant;
use App\Models\TouristService;
use App\Models\CrossingPort;
use App\Observers\PhotoObserver;
use App\Observers\ActivityObserver;
use App\Observers\MediaFileObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register existing observers
        MediaFile::observe(MediaFileObserver::class);
        Activity::observe(ActivityObserver::class);

        // Register PhotoObserver for all models with photo field
        User::observe(PhotoObserver::class);
        Client::observe(PhotoObserver::class);
        TouristService::observe(PhotoObserver::class);
        CrossingPort::observe(PhotoObserver::class);
        Airline::observe(PhotoObserver::class);
        Restaurant::observe(PhotoObserver::class);
        TourGuide::observe(PhotoObserver::class);
        Country::observe(PhotoObserver::class);

        if (Schema::hasTable('settings')) {
            $settings = Setting::first() ?? null;
            if ($settings && isset($settings->app_session_lifetime)) {
                // Admin and superadmin: 0 = unlimited session (1 year), or specified duration
                if (getActiveUser()) {
                    if (in_array(getActiveUser()->role, ['superadmin', 'admin'])) {
                        if ($settings->app_session_lifetime == 0) {
                            config(['session.lifetime' => 525600]); // Unlimited (1 year in minutes)
                        } else {
                            config(['session.lifetime' => (int) $settings->app_session_lifetime]);
                        }
                    } else {
                        // Regular users: 0 = unlimited, or >= 5 minutes (validated in UpdateRequest)
                        if ($settings->app_session_lifetime == 0 || $settings->app_session_lifetime < 5) {
                            config(['session.lifetime' => 120]); // Unlimited for regular users set to 2 hours
                        } else {
                            config(['session.lifetime' => (int) $settings->app_session_lifetime]);
                        }
                    }
                }
            }
        }
    }
}