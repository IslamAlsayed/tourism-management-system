<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Dashboard\Quotes\v1\QuoteController as QuoteControllerV1;
use App\Http\Controllers\Dashboard\Quotes\v2\QuoteController as QuoteControllerV2;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Admin\SidebarManagerController;

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
        Route::get('step3', [QuoteControllerV2::class, 'step3'])->name('dashboard.quote.v2.step3');
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
    Route::post('users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::post('users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

    // User Import
    Route::get('users/import/form', [ImportController::class, 'showUserImport'])->name('users.import.form');
    Route::post('users/import', [ImportController::class, 'importUsers'])->name('users.import');
    Route::get('users/import/sample', [ImportController::class, 'userSample'])->name('users.sample-import');

    // === LOCATION MANAGEMENT ===
    Route::resource('countries', CountryController::class)->names('countries');
    Route::post('countries/bulk-edit', [CountryController::class, 'bulkEdit'])->name('countries.bulkEdit');

    // Country Import
    Route::get('countries/import/form', [ImportController::class, 'showCountryImport'])->name('countries.import.form');
    Route::post('countries/import', [ImportController::class, 'importCountries'])->name('countries.import');
    Route::get('countries/import/sample', [ImportController::class, 'countrySample'])->name('countries.sample-import');

    Route::resource('cities', CityController::class)->names('cities');
    Route::get('cities/by-country/{countryId}', [CityController::class, 'getByCountry'])->name('cities.by-country');

    // City Import
    Route::get('cities/import/form', [ImportController::class, 'showCityImport'])->name('cities.import.form');
    Route::post('cities/import', [ImportController::class, 'importCities'])->name('cities.import');
    Route::get('cities/import/sample', [ImportController::class, 'citySample'])->name('cities.sample-import');

    // === FINANCIAL MANAGEMENT ===
    Route::resource('currencies', CurrencyController::class)->names('currencies');
    Route::get('currencies/rates', [CurrencyController::class, 'rates'])->name('currencies.rates');
    Route::post('currencies/rates/update', [CurrencyController::class, 'updateRates'])->name('currencies.rates.update');

    // Currency Import
    Route::get('currencies/import/form', [ImportController::class, 'showCurrencyImport'])->name('currencies.import.form');
    Route::post('currencies/import', [ImportController::class, 'importCurrencies'])->name('currencies.import');
    Route::get('currencies/import/sample', [ImportController::class, 'currencySample'])->name('currencies.sample-import');

    // === PROFILE MANAGEMENT ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
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
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::get('/security', [SettingsController::class, 'security'])->name('security');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::post('/backup/create', [SettingsController::class, 'createBackup'])->name('backup.create');
    });

    // === ADMIN TOOLS ===
    Route::prefix('admin/sidebar')->name('sidebar.')->middleware('admin')->group(function () {
        Route::get('/', [SidebarManagerController::class, 'index'])->name('index');
        Route::get('/test', fn() => view('sidebar-manager.test'))->name('test');
        Route::post('/update-order', [SidebarManagerController::class, 'updateOrder'])->name('update-order');
        Route::post('/toggle-visibility', [SidebarManagerController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/reset', [SidebarManagerController::class, 'resetToDefault'])->name('reset');
        Route::get('/export', [SidebarManagerController::class, 'exportConfig'])->name('export');
    });
});

require __DIR__ . '/auth.php';