<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\dashboard\CampController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\HotelController;
use App\Http\Controllers\dashboard\LodgeController;
use App\Http\Controllers\Dashboard\StateController;
use App\Http\Controllers\dashboard\HostelController;
use App\Http\Controllers\Dashboard\RegionController;
use App\Http\Controllers\dashboard\ResortController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\dashboard\ApartmentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SubregionController;
use App\Http\Controllers\Admin\SidebarManagerController;
use App\Http\Controllers\Dashboard\RestaurantController;
use App\Http\Controllers\Dashboard\NationalityController;
use App\Http\Controllers\Dashboard\AccommodationController;
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
    Route::post('users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::post('users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::get('users/import/data', [UserController::class, 'getUsersToImport'])->name('users.import');
    Route::post('users/import/post', [UserController::class, 'postUsersToImport'])->name('users.import.post');
    Route::get('users/export/data', [UserController::class, 'getUsersToExport'])->name('users.export');

    // === LOCATION MANAGEMENT ===
    // Route::resource('countries', CountryController::class)->names('countries');
    // Route::post('countries/bulk-edit', [CountryController::class, 'bulkEdit'])->name('countries.bulkEdit');

    // === CURRENCY MANAGEMENT ===
    Route::resource('currencies', CurrencyController::class)->names('currencies');
    Route::get('currencies/import/data', [CurrencyController::class, 'getCurrenciesToImport'])->name('currencies.import');
    Route::post('currencies/import/post', [CurrencyController::class, 'postCurrenciesToImport'])->name('currencies.import.post');
    Route::get('currencies/export/data', [CurrencyController::class, 'getCurrenciesToExport'])->name('currencies.export');

    // === COUNTRIES MANAGEMENT ===
    Route::resource('countries', CountryController::class)->names('countries');
    Route::get('countries/import/data', [CountryController::class, 'getCountriesToImport'])->name('countries.import');
    Route::post('countries/import/post', [CountryController::class, 'postCountriesToImport'])->name('countries.import.post');
    Route::get('countries/export/data', [CountryController::class, 'getCountriesToExport'])->name('countries.export');

    // === STATES MANAGEMENT ===
    Route::resource('states', StateController::class)->names('states');
    Route::get('states/import/data', [StateController::class, 'getStatesToImport'])->name('states.import');
    Route::post('states/import/post', [StateController::class, 'postStatesToImport'])->name('states.import.post');
    Route::get('states/export/data', [StateController::class, 'getStatesToExport'])->name('states.export');

    // === CITIES MANAGEMENT ===
    Route::resource('cities', CityController::class)->names('cities');
    Route::get('cities/import/data', [CityController::class, 'getCitiesToImport'])->name('cities.import');
    Route::post('cities/import/post', [CityController::class, 'postCitiesToImport'])->name('cities.import.post');
    Route::get('cities/export/data', [CityController::class, 'getCitiesToExport'])->name('cities.export');
    Route::get('cities/by-country/{countryId}', [CityController::class, 'getByCountry'])->name('cities.by-country');

    // === REGIONS MANAGEMENT ===
    Route::resource('regions', RegionController::class)->names('regions');
    Route::get('regions/import/data', [RegionController::class, 'getRegionsToImport'])->name('regions.import');
    Route::post('regions/import/post', [RegionController::class, 'postRegionsToImport'])->name('regions.import.post');
    Route::get('regions/export/data', [RegionController::class, 'getRegionsToExport'])->name('regions.export');

    // === SUBREGIONS MANAGEMENT ===
    Route::resource('subregions', SubregionController::class)->names('subregions');
    Route::get('subregions/import/data', [SubregionController::class, 'getSubregionsToImport'])->name('subregions.import');
    Route::post('subregions/import/post', [SubregionController::class, 'postSubregionsToImport'])->name('subregions.import.post');
    Route::get('subregions/export/data', [SubregionController::class, 'getSubregionsToExport'])->name('subregions.export');

    // === NATIONALITIES MANAGEMENT ===
    Route::resource('nationalities', NationalityController::class)->names('nationalities');
    Route::get('nationalities/import/data', [NationalityController::class, 'getNationalitiesToImport'])->name('nationalities.import');
    Route::post('nationalities/import/post', [NationalityController::class, 'postNationalitiesToImport'])->name('nationalities.import.post');
    Route::get('nationalities/export/data', [NationalityController::class, 'getNationalitiesToExport'])->name('nationalities.export');

    // === RESTAURANTS MANAGEMENT ===
    Route::resource('restaurants', RestaurantController::class)->names('restaurants');
    Route::get('restaurants/import/data', [RestaurantController::class, 'getRestaurantsToImport'])->name('restaurants.import');
    Route::post('restaurants/import/post', [RestaurantController::class, 'postRestaurantsToImport'])->name('restaurants.import.post');
    Route::get('restaurants/export/data', [RestaurantController::class, 'getRestaurantsToExport'])->name('restaurants.export');

    // === ACCOMMODATIONS MANAGEMENT ===
    Route::resource('accommodations', AccommodationController::class)->names('accommodations');
    Route::get('accommodations/{type}/type', [AccommodationController::class, 'getResultType'])->name('accommodations.type');
    Route::get('accommodations/import/data', [AccommodationController::class, 'getAccommodationsToImport'])->name('accommodations.import');
    Route::post('accommodations/import/post', [AccommodationController::class, 'postAccommodationsToImport'])->name('accommodations.import.post');
    Route::get('accommodations/export/data/{type}', [AccommodationController::class, 'getAccommodationsToExport'])->name('accommodations.export');

    // Route::get('hotels/create', [HotelController::class, 'create'])->name('hotels.create');
    // Route::get('resorts/create', [ResortController::class, 'create'])->name('resorts.create');
    // Route::get('camps/create', [CampController::class, 'create'])->name('camps.create');
    // Route::get('hostels/create', [HostelController::class, 'create'])->name('hostels.create');
    // Route::get('lodges/create', [LodgeController::class, 'create'])->name('lodges.create');
    // Route::get('apartments/create', [ApartmentController::class, 'create'])->name('apartments.create');

    // === FINANCIAL MANAGEMENT ===
    // Route::get('currencies/rates', [CurrencyController::class, 'rates'])->name('currencies.rates');
    // Route::post('currencies/rates/update', [CurrencyController::class, 'updateRates'])->name('currencies.rates.update');


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