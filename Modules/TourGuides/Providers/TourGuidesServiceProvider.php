<?php

namespace Modules\TourGuides\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\TourGuides\Entities\TourGuide;
use Modules\TourGuides\Entities\TourGuideLanguage;
use Modules\TourGuides\Entities\TourGuideReview;
use Modules\TourGuides\Entities\TourGuideType;
use Modules\TourGuides\Entities\TourGuideTypeCity;
use Modules\TourGuides\Entities\TourGuideTypeState;
use Modules\TourGuides\Livewire\Guides;
use Modules\TourGuides\Livewire\GuidesReviews;
use Modules\TourGuides\Livewire\GuidesTypes;
use Modules\TourGuides\Policies\TourGuideLanguagePolicy;
use Modules\TourGuides\Policies\TourGuidePolicy;
use Modules\TourGuides\Policies\TourGuideReviewPolicy;
use Modules\TourGuides\Policies\TourGuideTypeCityPolicy;
use Modules\TourGuides\Policies\TourGuideTypePolicy;
use Modules\TourGuides\Policies\TourGuideTypeStatePolicy;

class TourGuidesServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'TourGuides';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'tourguides';

    protected $policies = [
        TourGuideLanguage::class => TourGuideLanguagePolicy::class,
        TourGuide::class => TourGuidePolicy::class,
        TourGuideReview::class => TourGuideReviewPolicy::class,
        TourGuideTypeCity::class => TourGuideTypeCityPolicy::class,
        TourGuideType::class => TourGuideTypePolicy::class,
        TourGuideTypeState::class => TourGuideTypeStatePolicy::class,
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

        Livewire::component('tourguides::guides', Guides::class);
        Livewire::component('tourguides::guides-types', GuidesTypes::class);
        Livewire::component('tourguides::guides-reviews', GuidesReviews::class);

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
