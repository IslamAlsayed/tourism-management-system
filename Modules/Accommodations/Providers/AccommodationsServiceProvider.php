<?php

namespace Modules\Accommodations\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use App\Livewire\Accommodations\Types;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Accommodations\Entities\Meal;
use Modules\Accommodations\Entities\Room;
use Modules\Accommodations\Entities\Type;
use Modules\Accommodations\Livewire\Meals;
use Modules\Accommodations\Livewire\Rooms;
use Modules\Accommodations\Entities\Season;
use Modules\Accommodations\Livewire\Seasons;
use Modules\Accommodations\Entities\Supplement;
use Modules\Accommodations\Policies\MealPolicy;
use Modules\Accommodations\Policies\RoomPolicy;
use Modules\Accommodations\Policies\TypePolicy;
use Modules\Accommodations\Livewire\Supplements;
use Modules\Accommodations\Policies\SeasonPolicy;
use Modules\Accommodations\Entities\Accommodation;
use Modules\Accommodations\Livewire\Accommodations;
use Modules\Accommodations\Policies\SupplementPolicy;
use Modules\Accommodations\Policies\AccommodationPolicy;

class AccommodationsServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Accommodations';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'accommodations';

    protected $policies = [
        Accommodation::class => AccommodationPolicy::class,
        Type::class => TypePolicy::class,
        Room::class => RoomPolicy::class,
        Season::class => SeasonPolicy::class,
        Meal::class => MealPolicy::class,
        Supplement::class => SupplementPolicy::class,
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

        Livewire::component('accommodations::accommodations', Accommodations::class);
        Livewire::component('accommodations::types', Types::class);
        Livewire::component('accommodations::rooms', Rooms::class);
        Livewire::component('accommodations::seasons', Seasons::class);
        Livewire::component('accommodations::meals', Meals::class);
        Livewire::component('accommodations::supplements', Supplements::class);

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
