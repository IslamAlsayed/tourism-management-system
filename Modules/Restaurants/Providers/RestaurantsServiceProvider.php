<?php

namespace Modules\Restaurants\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Restaurants\Entities\Restaurant;
use Modules\Restaurants\Entities\RestaurantType;
use Modules\Restaurants\Livewire\Restaurants;
use Modules\Restaurants\Livewire\RestaurantMeals;
use Modules\Restaurants\Livewire\RestaurantTypes;
use Modules\Restaurants\Livewire\RestaurantSupplements;
use Modules\Restaurants\Livewire\Seasons;
use Modules\Restaurants\Policies\RestaurantPolicy;
use Modules\Restaurants\Policies\RestaurantTypePolicy;

class RestaurantsServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Restaurants';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'restaurants';

    protected $policies = [
        Restaurant::class => RestaurantPolicy::class,
        RestaurantType::class => RestaurantTypePolicy::class,
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

        Livewire::component('restaurants::restaurants', Restaurants::class);
        Livewire::component('restaurants::restaurant-types', RestaurantTypes::class);
        Livewire::component('restaurants::restaurant-meals', RestaurantMeals::class);
        Livewire::component('restaurants::restaurant-supplements', RestaurantSupplements::class);
        Livewire::component('restaurants::seasons', Seasons::class);

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
