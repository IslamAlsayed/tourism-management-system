<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\JeepController;
use App\Http\Controllers\Dashboard\MealController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\RoomController;
use App\Http\Controllers\Dashboard\TypeController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\SystemLanguageController;
use App\Http\Controllers\Dashboard\ExcelController;
use App\Http\Controllers\Dashboard\StateController;
use App\Http\Controllers\ColumnPreferenceController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\RegionController;
use App\Http\Controllers\Dashboard\SeasonController;
use App\Http\Controllers\Dashboard\AirlineController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\TimezoneController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MediaFileController;
use App\Http\Controllers\Dashboard\SubregionController;
use App\Http\Controllers\Admin\SidebarManagerController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RestaurantController;
use App\Http\Controllers\Dashboard\SupplementController;
use App\Http\Controllers\Dashboard\TravelPassController;
use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\NationalityController;
use App\Http\Controllers\Dashboard\TouristSiteController;
use App\Http\Controllers\Dashboard\Tours\GuideController;
use App\Http\Controllers\Dashboard\CrossingPortController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\AccommodationController;
use App\Http\Controllers\Dashboard\TouristServiceController;
use App\Http\Controllers\Dashboard\Tours\GuideTypeController;
use App\Http\Controllers\Dashboard\VisaRequirementController;
use App\Http\Controllers\Dashboard\Tours\GuideReviewController;
use App\Http\Controllers\Dashboard\Transportations\RouteController;
use App\Http\Controllers\Dashboard\Transportations\CompanyController;
use App\Http\Controllers\Dashboard\Transportations\PricingController;
use App\Http\Controllers\Dashboard\Transportations\VehicleTypeController;
use App\Http\Controllers\Dashboard\Transportations\RouteAssignmentController;
use App\Http\Controllers\Dashboard\Transportations\PricingDefinitionController;
use App\Http\Controllers\Dashboard\Quotes\v1\QuoteController as QuoteControllerV1;
use App\Http\Controllers\Dashboard\Quotes\v2\QuoteController as QuoteControllerV2;

/*
|----------------------|
|----- Web Routes -----|
|----------------------|
*/

Route::get('/', fn() => view('welcome'));

// Admin routes
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    // Dashboard Main
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('delete-all-selected-items', [DashboardController::class, 'deleteAll'])->name('deleteAll');

    // === COLUMN PREFERENCES ===
    Route::prefix('columns')->name('columns.')->group(function () {
        Route::post('/save', [ColumnPreferenceController::class, 'save'])->name('save');
        Route::post('/toggle-all', [ColumnPreferenceController::class, 'toggleAll'])->name('toggle-all');
        Route::post('/reset', [ColumnPreferenceController::class, 'reset'])->name('reset');
    });

    // === LANGUAGES ===
    Route::get('languages/{locale}/locale', [SystemLanguageController::class, 'locale'])->name('system-languages.change');
    Route::resource('system-languages', SystemLanguageController::class)->names('system-languages');
    Route::resource('languages', LanguageController::class)->names('languages');

    // === USER MANAGEMENT ===
    Route::resource('users', UserController::class)->names('users');

    // === ROLES & PERMISSIONS MANAGEMENT ===
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');

    // === CLIENT MANAGEMENT ===
    Route::resource('clients', ClientController::class)->names('clients');

    // === CROSSING PORTS MANAGEMENT ===
    Route::resource('crossings-ports', CrossingPortController::class)->names('crossings-ports');
    Route::get('crossings-ports/filtered/{filtered}', [CrossingPortController::class, 'filtered'])->name('crossings-ports.filtered');

    // === AIR TRANSPORT MANAGEMENT ===
    Route::resource('airlines', AirlineController::class)->names('airlines');
    Route::get('airlines/type/{type}', [AirlineController::class, 'type'])->name('airlines.type');

    // === MEDIA FILES MANAGEMENT ===
    Route::resource('media-files', MediaFileController::class)->names('media-files');
    Route::post('media-files/bulk-delete', [MediaFileController::class, 'bulkDelete'])->name('media-files.bulk-delete');

    // === TIMEZONE MANAGEMENT ===
    Route::resource('timezones', TimezoneController::class)->names('timezones');

    // === CURRENCY MANAGEMENT ===
    Route::resource('currencies', CurrencyController::class)->names('currencies');

    // === REGIONS MANAGEMENT ===
    Route::resource('regions', RegionController::class)->names('regions');

    // === SUBREGIONS MANAGEMENT ===
    Route::resource('subregions', SubregionController::class)->names('subregions');

    // === COUNTRIES MANAGEMENT ===
    Route::resource('countries', CountryController::class)->names('countries');

    // === STATES MANAGEMENT ===
    Route::resource('states', StateController::class)->names('states');

    // === CITIES MANAGEMENT ===
    Route::resource('cities', CityController::class)->names('cities');

    // === NATIONALITIES MANAGEMENT ===
    Route::resource('nationalities', NationalityController::class)->names('nationalities');

    // === RESTAURANTS MANAGEMENT ===
    Route::resource('restaurants', RestaurantController::class)->names('restaurants');

    // === TOUR GUIDES MANAGEMENT ===
    Route::prefix('tours')->name('tours.')->group(function () {
        Route::resource('guides', GuideController::class)->names('guides');
        Route::resource('guides-types', GuideTypeController::class)->names('guides-types');
        Route::resource('guides-reviews', GuideReviewController::class)->names('guides-reviews');
    });

    Route::resource('pricing-definitions', PricingDefinitionController::class)->names('pricing-definitions');

    // === TRANSPORTATIONS MANAGEMENT ===
    Route::prefix('transportations')->name('transportations.')->group(function () {
        Route::resource('companies', CompanyController::class)->names('companies');
        Route::resource('vehicle-types', VehicleTypeController::class)->names('vehicle-types');
        Route::resource('pricings', PricingController::class)->names('pricings');
        Route::resource('routes', RouteController::class)->names('routes');
        Route::resource('route-assignments', RouteAssignmentController::class)->names('route-assignments');
    });

    // === TOURIST MANAGEMENT ===
    Route::resource('tourist-sites', TouristSiteController::class)->names('tourist-sites');
    Route::resource('tourist-services', TouristServiceController::class)->names('tourist-services');

    // === JEEPS MANAGEMENT ===
    Route::resource('jeeps', JeepController::class)->names('jeeps');

    // === VISA REQUIREMENTS MANAGEMENT ===
    Route::resource('visa-requirements', VisaRequirementController::class)->names('visa-requirements');

    // === TRAVEL PASSES MANAGEMENT ===
    Route::resource('travel-passes', TravelPassController::class)->names('travel-passes');

    // === ACCOMMODATIONS MANAGEMENT ===
    Route::resource('accommodations', AccommodationController::class)->names('accommodations');
    Route::resource('types', TypeController::class)->names('types');
    Route::resource('seasons', SeasonController::class)->names('seasons');
    Route::resource('rooms', RoomController::class)->names('rooms');
    Route::resource('meals', MealController::class)->names('meals');
    Route::resource('supplements', SupplementController::class)->names('supplements');

    // === PROFILE MANAGEMENT ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::get('/change_password', [ProfileController::class, 'changePassword'])->name('change_password');
        Route::put('/update_password', [ProfileController::class, 'updatePassword'])->name('update_password');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');

        // Profile Settings Pages
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/test', [ProfileController::class, 'settingsTest'])->name('test');
            Route::get('/new', [ProfileController::class, 'settingsNew'])->name('new');
            Route::get('/final', [ProfileController::class, 'settingsFinal'])->name('final');
            Route::get('/security', [ProfileController::class, 'security'])->name('security');
            Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        });
    });

    // Alternative Profile
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');

    // === REPORTS ===
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/users', [ReportsController::class, 'users'])->name('users');
        Route::get('/locations', [ReportsController::class, 'locations'])->name('locations');
        Route::get('/analytics', [ReportsController::class, 'analytics'])->name('analytics');
    });

    // === SYSTEM SETTINGS ===    
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('general', [SettingsController::class, 'general'])->name('general');
        Route::get('security', [SettingsController::class, 'security'])->name('security');
        Route::get('notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::get('backup', [SettingsController::class, 'backup'])->name('backup');
        Route::get('booking', [SettingsController::class, 'booking'])->name('booking');
        Route::get('integration', [SettingsController::class, 'integration'])->name('integration');
        Route::get('system', [SettingsController::class, 'system'])->name('system');
        Route::post('backup/create', [SettingsController::class, 'createBackup'])->name('backup.create');
    });
    Route::resource('settings', SettingsController::class)->names('settings');

    // === ACTIVITY LOG ===
    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

    // === ADMIN TOOLS ===
    Route::prefix('admin/sidebar')->name('sidebar.')->middleware('admin')->group(function () {
        Route::get('/', [SidebarManagerController::class, 'index'])->name('index');
        Route::get('/test', fn() => view('sidebar-manager.test'))->name('test');
        Route::post('/update-order', [SidebarManagerController::class, 'updateOrder'])->name('update-order');
        Route::post('/toggle-visibility', [SidebarManagerController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/reset', [SidebarManagerController::class, 'resetToDefault'])->name('reset');
        Route::get('/export', [SidebarManagerController::class, 'exportConfig'])->name('export');
    });

    // === NOTIFICATIONS ===
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');

        // Keep API routes for any AJAX calls if needed
        Route::get('/recent', [NotificationController::class, 'getRecent'])->name('recent');
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/{notification}/mark-unread', [NotificationController::class, 'markAsUnread'])->name('mark-unread');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Route::get('import/data?{model?}&{models?}&{view?}', [ExcelController::class, 'import'])->name('import.data');
    Route::get('import/data', [ExcelController::class, 'import'])->name('import.data');
    Route::post('import/{models}/data/{type?}', [ExcelController::class, 'importData'])->name('import.data.post');
    Route::get('export/{models}/data/{type?}', [ExcelController::class, 'exportData'])->name('export.data');
});

require __DIR__ . '/auth.php';
