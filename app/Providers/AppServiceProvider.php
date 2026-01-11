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
                // If session lifetime is 0 and user is admin, set unlimited session (1 year)
                if ($settings->app_session_lifetime == 0 && getActiveUser() && getActiveUser()->is_admin) {
                    config(['session.lifetime' => 525600]); // 1 year in minutes
                } elseif ($settings->app_session_lifetime > 0) {
                    config(['session.lifetime' => (int) $settings->app_session_lifetime]);
                }
            }
        }
    }
}