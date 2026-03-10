<?php

namespace App\Providers;

use App\Models\Airline;
use App\Models\EntryPoint;
use App\Models\MediaFile;
use App\Models\Notification;
use App\Models\RichText;
use App\Models\SidebarMenuOrder;
use App\Models\StarRating;
use App\Models\TableColumn;
use App\Policies\AirlinePolicy;
use App\Policies\EntryPointPolicy;
use App\Policies\MediaFilePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\RichTextPolicy;
use App\Policies\SidebarMenuOrderPolicy;
use App\Policies\StarRatingPolicy;
use App\Policies\TableColumnPolicy;
use App\Policies\TouristServicePolicy;
use App\Policies\TouristSitePolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Core\Entities\FieldDefinition;
use Modules\Core\Entities\PricingDefinition;
use Modules\Core\Entities\User;
use Modules\Core\Policies\FieldDefinitionPolicy;
use Modules\Core\Policies\PricingDefinitionPolicy;
use Modules\TouristServices\Entities\TouristService;
use Modules\TouristSites\Entities\TouristSite;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [

        // Application Models
        Airline::class => AirlinePolicy::class,
        EntryPoint::class => EntryPointPolicy::class,
        MediaFile::class => MediaFilePolicy::class,
        Notification::class => NotificationPolicy::class,
        PricingDefinition::class => PricingDefinitionPolicy::class,
        FieldDefinition::class => FieldDefinitionPolicy::class,
        RichText::class => RichTextPolicy::class,
        SidebarMenuOrder::class => SidebarMenuOrderPolicy::class,
        StarRating::class => StarRatingPolicy::class,
        TableColumn::class => TableColumnPolicy::class,
        TouristService::class => TouristServicePolicy::class,
        TouristSite::class => TouristSitePolicy::class,
        \Modules\Geography\Entities\Nationality::class => \App\Policies\NationalityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Register superadmin bypass AFTER all service providers have booted
        // This ensures it runs after Spatie's PermissionServiceProvider registers its Gate::before
        // via callAfterResolving(Gate::class), which would otherwise intercept can() checks
        $this->app->booted(function () {
            \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
                return $user->hasRole('superadmin') ? true : null;
            });
        });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('FRONTEND_URL')."/password-reset/$token?email=".urlencode($user->email);
        });
    }
}
