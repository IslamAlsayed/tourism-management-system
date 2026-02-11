<?php

namespace Modules\Localization\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Localization\Entities\Currency;
use Modules\Localization\Entities\Language;
use Modules\Localization\Entities\Timezone;
use Modules\Localization\Livewire\Languages;
use Modules\Localization\Livewire\Timezones;
use Modules\Localization\Livewire\Currencies;
use Modules\Localization\Entities\SystemLanguage;
use Modules\Localization\Policies\CurrencyPolicy;
use Modules\Localization\Policies\LanguagePolicy;
use Modules\Localization\Policies\TimezonePolicy;
use Modules\Localization\Livewire\SystemLanguages;
use Modules\Localization\Policies\SystemLanguagePolicy;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Localization';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'localization';

    protected $policies = [
        Language::class => LanguagePolicy::class,
        Currency::class => CurrencyPolicy::class,
        SystemLanguage::class => SystemLanguagePolicy::class,
        Timezone::class => TimezonePolicy::class,
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

        Livewire::component('localization::languages', Languages::class);
        Livewire::component('localization::system_languages', SystemLanguages::class);
        Livewire::component('localization::currencies', Currencies::class);
        Livewire::component('localization::timezones', Timezones::class);

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
