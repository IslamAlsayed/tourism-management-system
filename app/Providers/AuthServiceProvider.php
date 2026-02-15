<?php

namespace App\Providers;

use App\Models\Airline;
use App\Models\MediaFile;
use App\Models\Notification;
use App\Models\RichText;
use App\Models\SidebarMenuOrder;
use App\Models\StarRating;
use App\Models\TableColumn;
use App\Policies\AirlinePolicy;
use App\Policies\MediaFilePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\RichTextPolicy;
use App\Policies\SidebarMenuOrderPolicy;
use App\Policies\StarRatingPolicy;
use App\Policies\TableColumnPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Core\Entities\User;

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
        MediaFile::class => MediaFilePolicy::class,
        Notification::class => NotificationPolicy::class,
        RichText::class => RichTextPolicy::class,
        SidebarMenuOrder::class => SidebarMenuOrderPolicy::class,
        StarRating::class => StarRatingPolicy::class,
        TableColumn::class => TableColumnPolicy::class,
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
