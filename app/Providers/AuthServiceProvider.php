<?php

namespace App\Providers;

use Modules\Core\Entities\User;
use App\Models\Airline;
use App\Models\RichText;
use App\Models\MediaFile;
use App\Models\StarRating;
use App\Models\TableColumn;
use Modules\Tourists\Entities\TouristSite;
use App\Models\CrossingPort;
use App\Models\Notification;
use Modules\Tourists\Entities\TouristService;
use App\Policies\AirlinePolicy;
use App\Models\SidebarMenuOrder;
use App\Policies\RichTextPolicy;
use App\Models\PricingDefinition;
use App\Policies\MediaFilePolicy;
use App\Policies\StarRatingPolicy;
use App\Policies\TableColumnPolicy;
use App\Policies\TouristSitePolicy;
use App\Policies\CrossingPortPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\TouristServicePolicy;
use App\Policies\SidebarMenuOrderPolicy;
use App\Policies\PricingDefinitionPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        CrossingPort::class => CrossingPortPolicy::class,
        MediaFile::class => MediaFilePolicy::class,
        Notification::class => NotificationPolicy::class,
        PricingDefinition::class => PricingDefinitionPolicy::class,
        RichText::class => RichTextPolicy::class,
        SidebarMenuOrder::class => SidebarMenuOrderPolicy::class,
        StarRating::class => StarRatingPolicy::class,
        TableColumn::class => TableColumnPolicy::class,
        TouristService::class => TouristServicePolicy::class,
        TouristSite::class => TouristSitePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('FRONTEND_URL') . "/password-reset/$token?email=" . urlencode($user->email);
        });
    }
}
