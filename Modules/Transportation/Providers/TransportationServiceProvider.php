<?php

namespace Modules\Transportation\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Transportation\Entities\Jeep;
use Modules\Transportation\Entities\Route;
use Modules\Transportation\Livewire\Jeeps;
use Modules\Transportation\Livewire\Routes;
use Modules\Transportation\Entities\Company;
use Modules\Transportation\Entities\Pricing;
use Modules\Transportation\Livewire\Pricings;
use Modules\Transportation\Livewire\Companies;
use Modules\Transportation\Policies\JeepPolicy;
use Modules\Transportation\Entities\VehicleType;
use Modules\Transportation\Policies\RoutePolicy;
use Modules\Transportation\Livewire\PricingSteps;
use Modules\Transportation\Livewire\VehicleTypes;
use Modules\Transportation\Policies\CompanyPolicy;
use Modules\Transportation\Policies\PricingPolicy;
use Modules\Transportation\Entities\CompanyContact;
use Modules\Transportation\Entities\RouteAssignment;
use Modules\Transportation\Livewire\RouteAssignment as RouteAssignmentComponent;
use Modules\Transportation\Livewire\RouteAssignments;
use Modules\Transportation\Livewire\Seasons;
use Modules\Transportation\Livewire\Supplements;
use Modules\Transportation\Policies\VehicleTypePolicy;
use Modules\Transportation\Policies\CompanyContactPolicy;
use Modules\Transportation\Policies\RouteAssignmentPolicy;

class TransportationServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Transportation';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'transportation';

    protected $policies = [
        Company::class => CompanyPolicy::class,
        CompanyContact::class => CompanyContactPolicy::class,
        Pricing::class => PricingPolicy::class,
        Route::class => RoutePolicy::class,
        RouteAssignment::class => RouteAssignmentPolicy::class,
        VehicleType::class => VehicleTypePolicy::class,
        Jeep::class => JeepPolicy::class,
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        Livewire::component('transportation::companies', Companies::class);
        Livewire::component('transportation::pricings', Pricings::class);
        Livewire::component('transportation::route-assignments', RouteAssignments::class);
        Livewire::component('transportation::route-assignment', RouteAssignmentComponent::class);
        Livewire::component('transportation::routes', Routes::class);
        Livewire::component('transportation::vehicle-types', VehicleTypes::class);
        Livewire::component('transportation::pricing-steps', PricingSteps::class);
        Livewire::component('transportation::jeeps', Jeeps::class);
        Livewire::component('transportation::seasons', Seasons::class);
        Livewire::component('transportation::supplements', Supplements::class);

        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
