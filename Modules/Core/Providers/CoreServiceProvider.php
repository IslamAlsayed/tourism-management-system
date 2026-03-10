<?php

namespace Modules\Core\Providers;

use Livewire\Livewire;
use Modules\Core\Entities\User;
use Modules\Core\Livewire\Roles;
use Modules\Core\Livewire\Users;
use Modules\Core\Entities\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Policies\RolePolicy;
use Modules\Core\Policies\UserPolicy;
use Illuminate\Support\Facades\Config;
use Modules\Core\Livewire\ActivityLog;
use Modules\Core\Livewire\Permissions;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Modules\Core\Policies\SettingPolicy;
use Spatie\Permission\Models\Permission;
use Modules\Core\Policies\ActivityPolicy;
use Modules\Core\Policies\PermissionPolicy;
use Modules\Core\Entities\PricingDefinition;
use Modules\Core\Livewire\PricingDefinitions;
use Modules\Core\Livewire\FieldDefinitions;
use Modules\Core\Policies\PricingDefinitionPolicy;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

    protected array $policies = [
        // Spatie Permission Models
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Setting::class => SettingPolicy::class,
        User::class => UserPolicy::class,
        PricingDefinition::class => PricingDefinitionPolicy::class,
        Activity::class => ActivityPolicy::class,
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

        Livewire::component('core::roles', Roles::class);
        Livewire::component('core::permissions', Permissions::class);
        Livewire::component('core::users', Users::class);
        Livewire::component('core::pricing-definitions', PricingDefinitions::class);
        Livewire::component('core::field-definitions', FieldDefinitions::class);
        Livewire::component('core::activity-log', ActivityLog::class);

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
