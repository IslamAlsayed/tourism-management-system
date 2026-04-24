<?php

namespace App\Providers;

use App\Models\Airline;
use App\Models\MediaFile;
use Modules\Core\Entities\User;
use App\Observers\PhotoObserver;
use Modules\CRM\Entities\Client;
use Modules\Core\Entities\Setting;
use App\Observers\ActivityObserver;
use App\Observers\MediaFileObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Geography\Entities\Country;
use Spatie\Activitylog\Models\Activity;
use Modules\TourGuides\Entities\TourGuide;
use Modules\EntryPoints\Entities\Landcrossing;
use Modules\Restaurants\Entities\Restaurant;
use Modules\TouristServices\Entities\TouristService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ------------------------------------------------------------------
        // Legacy class aliases: old App\Models\* → new Modules\*\Entities\*
        // These aliases allow legacy Quote controllers (v1/v2) and the
        // multi-step form to keep working without rewriting every import.
        // TODO: Migrate all code to use Module namespaces directly, then
        //       remove these aliases.
        // ------------------------------------------------------------------
        $aliases = [
            // Accommodations
            'App\\Models\\Hotel'            => \Modules\Accommodations\Entities\Accommodation::class,
            'App\\Models\\HotelSeason'      => \Modules\Accommodations\Entities\Season::class,
            'App\\Models\\HotelRoomType'    => \Modules\Accommodations\Entities\Room::class,
            'App\\Models\\HotelSupplement'  => \Modules\Accommodations\Entities\Supplement::class,
            'App\\Models\\AccommodationType' => \Modules\Accommodations\Entities\Type::class,

            // Geography
            'App\\Models\\City'             => \Modules\Geography\Entities\City::class,
            'App\\Models\\Country'          => \Modules\Geography\Entities\Country::class,
            'App\\Models\\Subregion'        => \Modules\Geography\Entities\Subregion::class,
            'App\\Models\\Nationality'      => \Modules\Geography\Entities\Nationality::class,

            // Localization
            'App\\Models\\Currency'         => \Modules\Localization\Entities\Currency::class,

            // Transportation
            'App\\Models\\TransportationCompany' => \Modules\Transportation\Entities\Company::class,
            'App\\Models\\BusType'               => \Modules\Transportation\Entities\VehicleType::class,
        ];

        foreach ($aliases as $alias => $concrete) {
            if (!class_exists($alias, false)) {
                class_alias($concrete, $alias);
            }
        }
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
        Landcrossing::observe(PhotoObserver::class);
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
