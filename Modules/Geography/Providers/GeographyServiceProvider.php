<?php

namespace Modules\Geography\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\State;
use Illuminate\Support\Facades\Config;
use Modules\Geography\Entities\Region;
use Modules\Geography\Livewire\Cities;
use Modules\Geography\Livewire\States;
use Illuminate\Support\ServiceProvider;
use Modules\Geography\Entities\Country;
use Modules\Geography\Livewire\Regions;
use Modules\Geography\Entities\Subregion;
use Modules\Geography\Livewire\Countries;
use Modules\Geography\Livewire\Subregions;
use Modules\Geography\Policies\CityPolicy;
use Modules\Geography\Policies\StatePolicy;
use Modules\Geography\Policies\RegionPolicy;
use Modules\Geography\Livewire\Nationalities;
use Modules\Geography\Policies\CountryPolicy;
use Modules\Geography\Policies\SubregionPolicy;
use Modules\Geography\Livewire\Regions\LocationToCity;
use Modules\Geography\Livewire\Regions\LocationToState;
use Modules\Geography\Livewire\Regions\LocationToCountry;
use Modules\Geography\Livewire\Regions\LocationSelectBase;
use Modules\Geography\Livewire\Regions\LocationSelectBase2;

class GeographyServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Geography';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'geography';

    protected array $policies = [
        Region::class => RegionPolicy::class,
        Subregion::class => SubregionPolicy::class,
        Country::class => CountryPolicy::class,
        State::class => StatePolicy::class,
        City::class => CityPolicy::class,
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

        Livewire::component('geography::regions', Regions::class);
        Livewire::component('geography::subregions', Subregions::class);
        Livewire::component('geography::countries', Countries::class);
        Livewire::component('geography::states', States::class);
        Livewire::component('geography::cities', Cities::class);
        Livewire::component('geography::nationalities', Nationalities::class);
        Livewire::component('geography::livewire.regions.location-to-country', LocationToCountry::class);
        Livewire::component('geography::livewire.regions.location-to-city', LocationToCity::class);
        Livewire::component('geography::livewire.regions.location-to-state', LocationToState::class);
        Livewire::component('geography::livewire.regions.location-select-base', LocationSelectBase::class);
        Livewire::component('geography::livewire.regions.location-select-base2', LocationSelectBase2::class);

        // === Register Policies ===
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
