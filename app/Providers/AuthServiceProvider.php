<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Accommodation;
use App\Models\Airline;
use App\Models\City;
use App\Models\CityState;
use App\Models\Client;
use App\Models\Country;
use App\Models\CrossingPort;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Meal;
use App\Models\MediaFile;
use App\Models\Nationality;
use App\Models\Notification;
use App\Models\PricingDefinition;
use App\Models\Region;
use App\Models\Restaurant;
use App\Models\RichText;
use App\Models\Room;
use App\Models\Season;
use App\Models\Setting;
use App\Models\SidebarMenuOrder;
use App\Models\StarRating;
use App\Models\State;
use App\Models\Subregion;
use App\Models\Supplement;
use App\Models\SystemLanguage;
use App\Models\TableColumn;
use App\Models\Timezone;
use App\Models\TourGuide;
use App\Models\TourGuideLanguage;
use App\Models\TourGuideReview;
use App\Models\TourGuideType;
use App\Models\TourGuideTypeCity;
use App\Models\TourGuideTypeState;
use App\Models\TouristService;
use App\Models\TouristSite;
use App\Models\TransportationCompany;
use App\Models\TransportationCompanyContact;
use App\Models\TransportationPricing;
use App\Models\TransportationRoute;
use App\Models\TransportationRouteAssignment;
use App\Models\TransportationVehicleType;
use App\Models\Type;
use App\Policies\AccommodationPolicy;
use App\Policies\AirlinePolicy;
use App\Policies\CityPolicy;
use App\Policies\CityStatePolicy;
use App\Policies\ClientPolicy;
use App\Policies\CountryPolicy;
use App\Policies\CrossingPortPolicy;
use App\Policies\CurrencyPolicy;
use App\Policies\LanguagePolicy;
use App\Policies\MealPolicy;
use App\Policies\MediaFilePolicy;
use App\Policies\NationalityPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\PricingDefinitionPolicy;
use App\Policies\RegionPolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\RichTextPolicy;
use App\Policies\RoomPolicy;
use App\Policies\SeasonPolicy;
use App\Policies\SettingPolicy;
use App\Policies\SidebarMenuOrderPolicy;
use App\Policies\StarRatingPolicy;
use App\Policies\StatePolicy;
use App\Policies\SubregionPolicy;
use App\Policies\SupplementPolicy;
use App\Policies\SystemLanguagePolicy;
use App\Policies\TableColumnPolicy;
use App\Policies\TimezonePolicy;
use App\Policies\TourGuidePolicy;
use App\Policies\TourGuideLanguagePolicy;
use App\Policies\TourGuideReviewPolicy;
use App\Policies\TourGuideTypePolicy;
use App\Policies\TourGuideTypeCityPolicy;
use App\Policies\TourGuideTypeStatePolicy;
use App\Policies\TouristServicePolicy;
use App\Policies\TouristSitePolicy;
use App\Policies\TransportationCompanyPolicy;
use App\Policies\TransportationCompanyContactPolicy;
use App\Policies\TransportationPricingPolicy;
use App\Policies\TransportationRoutePolicy;
use App\Policies\TransportationRouteAssignmentPolicy;
use App\Policies\TransportationVehicleTypePolicy;
use App\Policies\TypePolicy;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Spatie Permission Models
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,

        // Application Models
        Accommodation::class => AccommodationPolicy::class,
        Airline::class => AirlinePolicy::class,
        City::class => CityPolicy::class,
        CityState::class => CityStatePolicy::class,
        Client::class => ClientPolicy::class,
        Country::class => CountryPolicy::class,
        CrossingPort::class => CrossingPortPolicy::class,
        Currency::class => CurrencyPolicy::class,
        Language::class => LanguagePolicy::class,
        Meal::class => MealPolicy::class,
        MediaFile::class => MediaFilePolicy::class,
        Nationality::class => NationalityPolicy::class,
        Notification::class => NotificationPolicy::class,
        PricingDefinition::class => PricingDefinitionPolicy::class,
        Region::class => RegionPolicy::class,
        Restaurant::class => RestaurantPolicy::class,
        RichText::class => RichTextPolicy::class,
        Room::class => RoomPolicy::class,
        Season::class => SeasonPolicy::class,
        Setting::class => SettingPolicy::class,
        SidebarMenuOrder::class => SidebarMenuOrderPolicy::class,
        StarRating::class => StarRatingPolicy::class,
        State::class => StatePolicy::class,
        Subregion::class => SubregionPolicy::class,
        Supplement::class => SupplementPolicy::class,
        SystemLanguage::class => SystemLanguagePolicy::class,
        TableColumn::class => TableColumnPolicy::class,
        Timezone::class => TimezonePolicy::class,
        TourGuide::class => TourGuidePolicy::class,
        TourGuideLanguage::class => TourGuideLanguagePolicy::class,
        TourGuideReview::class => TourGuideReviewPolicy::class,
        TourGuideType::class => TourGuideTypePolicy::class,
        TourGuideTypeCity::class => TourGuideTypeCityPolicy::class,
        TourGuideTypeState::class => TourGuideTypeStatePolicy::class,
        TouristService::class => TouristServicePolicy::class,
        TouristSite::class => TouristSitePolicy::class,
        TransportationCompany::class => TransportationCompanyPolicy::class,
        TransportationCompanyContact::class => TransportationCompanyContactPolicy::class,
        TransportationPricing::class => TransportationPricingPolicy::class,
        TransportationRoute::class => TransportationRoutePolicy::class,
        TransportationRouteAssignment::class => TransportationRouteAssignmentPolicy::class,
        TransportationVehicleType::class => TransportationVehicleTypePolicy::class,
        Type::class => TypePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('FRONTEND_URL') . "/password-reset/$token?email=" . urlencode($user->email);
        });
    }
}
