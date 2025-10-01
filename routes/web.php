<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ExcelController;
use App\Http\Controllers\Dashboard\StateController;
use App\Http\Controllers\Dashboard\RegionController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SubregionController;
use App\Http\Controllers\Dashboard\TourGuideController;
use App\Http\Controllers\Admin\SidebarManagerController;
use App\Http\Controllers\Dashboard\RestaurantController;
use App\Http\Controllers\Dashboard\NationalityController;
use App\Http\Controllers\Dashboard\AccommodationController;
use App\Http\Controllers\Dashboard\TourGuideTypeController;
use App\Http\Controllers\Dashboard\TransportationController;
use App\Http\Controllers\Dashboard\TourGuideReviewController;
use App\Http\Controllers\Dashboard\Transportation\CompanyController;
use App\Http\Controllers\Dashboard\Transportation\DepartmentController;
use App\Http\Controllers\Dashboard\Quotes\v1\QuoteController as QuoteControllerV1;
use App\Http\Controllers\Dashboard\Quotes\v2\QuoteController as QuoteControllerV2;

Route::get('/dashboard/countries/metronic-table', function () {
    return view('pages.dashboard.countries.metronic-table');
})->middleware('auth');

/*
|--------------------|
|---- Web Routes ----|
|--------------------|
*/

Route::get('/', fn() => view('welcome'));

// Admin routes
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    // Dashboard Main
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::delete('delete-all-selected-items', [DashboardController::class, 'deleteAll'])->name('deleteAll');

    // Legacy multi-step form routes (keeping for reference)
    Route::prefix('quote/v1')->group(function () {
        Route::get('step1', [QuoteControllerV1::class, 'step1'])->name('dashboard.quote.v1.step1');
        Route::post('step1', [QuoteControllerV1::class, 'postStep1'])->name('dashboard.quote.v1.postStep1');

        Route::get('{id}/step2', [QuoteControllerV1::class, 'step2'])->name('dashboard.quote.v1.step2');
        Route::post('{id}/step2', [QuoteControllerV1::class, 'postStep2'])->name('dashboard.quote.v1.postStep2');

        Route::get('{id}/step3', [QuoteControllerV1::class, 'step3'])->name('dashboard.quote.v1.step3');
        Route::post('{id}/step3', [QuoteControllerV1::class, 'postStep3'])->name('dashboard.quote.v1.postStep3');

        Route::get('{id}/step4', [QuoteControllerV1::class, 'step4'])->name('dashboard.quote.v1.step4');
        Route::post('{id}/submit', [QuoteControllerV1::class, 'submit'])->name('dashboard.quote.v1.submit');
    });

    Route::prefix('quote/v2')->group(function () {
        Route::get('/', [QuoteControllerV2::class, 'index'])->name('dashboard.quote.v2.index');
        Route::get('step1', [QuoteControllerV2::class, 'step1'])->name('dashboard.quote.v2.step1');
        Route::post('step1', [QuoteControllerV2::class, 'postStep1'])->name('dashboard.quote.v2.postStep1');
        Route::get('step2', [QuoteControllerV2::class, 'step2'])->name('dashboard.quote.v2.step2');
        Route::post('step2', [QuoteControllerV2::class, 'postStep2'])->name('dashboard.quote.v2.postStep2');
        Route::get('step3', [QuoteControllerV2::class, 'step3'])->name('dashboard.quote.v2.step3');
        Route::post('step3', [QuoteControllerV2::class, 'postStep3'])->name('dashboard.quote.v2.postStep3');
        Route::get('step4', [QuoteControllerV2::class, 'step4'])->name('dashboard.quote.v2.step4');
        Route::post('step4', [QuoteControllerV2::class, 'postStep4'])->name('dashboard.quote.v2.postStep4');
        Route::get('submit', [QuoteControllerV2::class, 'submit'])->name('dashboard.quote.v2.submit');
        Route::post('get-hotels-by-countries-and-cities', [QuoteControllerV2::class, 'getHotelsByCountriesAndCities']);
        Route::post('get-transportation', [QuoteControllerV2::class, 'getTransportation']);
    });

    Route::get('/main-form', [DashboardController::class, 'mainForm'])->name('dashboard.mainForm');

    // === LANGUAGES ===
    Route::get('languages/{locale}/locale', [LanguageController::class, 'locale'])->name('languages.change');
    Route::resource('languages', LanguageController::class)->names('languages');

    // === USER MANAGEMENT ===
    Route::resource('users', UserController::class)->names('users');

    // === CURRENCY MANAGEMENT ===
    Route::resource('currencies', CurrencyController::class)->names('currencies');

    // === COUNTRIES MANAGEMENT ===
    Route::resource('countries', CountryController::class)->names('countries');

    // === STATES MANAGEMENT ===
    Route::resource('states', StateController::class)->names('states');

    // === CITIES MANAGEMENT ===
    Route::resource('cities', CityController::class)->names('cities');
    Route::get('cities/by-country/{countryId}', [CityController::class, 'getByCountry'])->name('cities.by-country');

    // === REGIONS MANAGEMENT ===
    Route::resource('regions', RegionController::class)->names('regions');

    // === SUBREGIONS MANAGEMENT ===
    Route::resource('subregions', SubregionController::class)->names('subregions');

    // === NATIONALITIES MANAGEMENT ===
    Route::resource('nationalities', NationalityController::class)->names('nationalities');

    // === RESTAURANTS MANAGEMENT ===
    Route::resource('restaurants', RestaurantController::class)->names('restaurants');

    // === TOUR GUIDES MANAGEMENT ===
    Route::resource('tour-guides', TourGuideController::class)->names('tour-guides');
    Route::resource('tour-guides-types', TourGuideTypeController::class)->names('tour-guides-types');
    Route::resource('tour-guides-reviews', TourGuideReviewController::class)->names('tour-guides-reviews');

    // === TRANSPORTATION MANAGEMENT ===
    Route::resource('transportation/companies', CompanyController::class)->names('transportation-companies');
    Route::resource('transportation/departments', DepartmentController::class)->names('transportation-departments');

    // === ACCOMMODATIONS MANAGEMENT ===
    Route::resource('accommodations', AccommodationController::class)->names('accommodations');
    Route::get('accommodations/{type}/type', [AccommodationController::class, 'getResultType'])->name('accommodations.type');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::get('/change_password', [ProfileController::class, 'changePassword'])->name('change_password');
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
    Route::get('settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::get('settings/security', [SettingsController::class, 'security'])->name('settings.security');
    Route::get('settings/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::get('settings/backup', [SettingsController::class, 'backup'])->name('settings.backup');
    Route::post('settings/backup/create', [SettingsController::class, 'createBackup'])->name('settings.backup.create');
    Route::resource('settings', SettingsController::class)->names('settings');

    // === ADMIN TOOLS ===
    Route::prefix('admin/sidebar')->name('sidebar.')->middleware('admin')->group(function () {
        Route::get('/', [SidebarManagerController::class, 'index'])->name('index');
        Route::get('/test', fn() => view('sidebar-manager.test'))->name('test');
        Route::post('/update-order', [SidebarManagerController::class, 'updateOrder'])->name('update-order');
        Route::post('/toggle-visibility', [SidebarManagerController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/reset', [SidebarManagerController::class, 'resetToDefault'])->name('reset');
        Route::get('/export', [SidebarManagerController::class, 'exportConfig'])->name('export');
    });

    Route::get('import/{model}/data', [ExcelController::class, 'getToImport'])->name('import.data');
    Route::post('import/{model}/data/{type?}', [ExcelController::class, 'postToImport'])->name('import.data.post');
    Route::get('export/{model}/data/{type?}', [ExcelController::class, 'getToExport'])->name('export.data');
});

require __DIR__ . '/auth.php';