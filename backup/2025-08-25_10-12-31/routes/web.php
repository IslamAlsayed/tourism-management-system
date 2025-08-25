<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\CurrencyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Test language route
Route::get('/test-language', function () {
    return view('test-language');
})->name('test.language');

// Language switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

// Admin routes
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    // Dashboard Main
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // === USER MANAGEMENT ===
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::post('/{id}/activate', [UserController::class, 'activate'])->name('activate');
        Route::post('/{id}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
    });

    // === LOCATION MANAGEMENT ===
    // Countries
    Route::prefix('countries')->name('countries.')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');
        Route::get('/create', [CountryController::class, 'create'])->name('create');
        Route::post('/', [CountryController::class, 'store'])->name('store');
        Route::get('/{id}', [CountryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CountryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CountryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CountryController::class, 'destroy'])->name('delete');
    });

    // Cities
    Route::prefix('cities')->name('cities.')->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('index');
        Route::get('/create', [CityController::class, 'create'])->name('create');
        Route::post('/', [CityController::class, 'store'])->name('store');
        Route::get('/{id}', [CityController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CityController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CityController::class, 'update'])->name('update');
        Route::delete('/{id}', [CityController::class, 'destroy'])->name('delete');
        Route::get('/by-country/{countryId}', [CityController::class, 'getByCountry'])->name('by-country');
    });

    // === FINANCIAL MANAGEMENT ===
    Route::prefix('currencies')->name('currencies.')->group(function () {
        Route::get('/', [CurrencyController::class, 'index'])->name('index');
        Route::get('/create', [CurrencyController::class, 'create'])->name('create');
        Route::post('/', [CurrencyController::class, 'store'])->name('store');
        Route::get('/{id}', [CurrencyController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CurrencyController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CurrencyController::class, 'update'])->name('update');
        Route::delete('/{id}', [CurrencyController::class, 'destroy'])->name('delete');
        Route::get('/rates', [CurrencyController::class, 'rates'])->name('rates');
        Route::post('/rates/update', [CurrencyController::class, 'updateRates'])->name('rates.update');
    });

    // === PROFILE MANAGEMENT ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('update');
        Route::post('/photo', [App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('photo');
        Route::delete('/', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('destroy');
        
        // Profile Settings Pages
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/test', [App\Http\Controllers\ProfileController::class, 'settingsTest'])->name('test');
            Route::get('/new', [App\Http\Controllers\ProfileController::class, 'settingsNew'])->name('new');
            Route::get('/final', [App\Http\Controllers\ProfileController::class, 'settingsFinal'])->name('final');
            Route::get('/security', [App\Http\Controllers\ProfileController::class, 'security'])->name('security');
            Route::get('/notifications', [App\Http\Controllers\ProfileController::class, 'notifications'])->name('notifications');
        });
    });

    // User Profile (Alternative route)
    Route::get('/user/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('user.profile');

    // === REPORTS & ANALYTICS ===
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function() { return view('dashboard.reports.index'); })->name('index');
        Route::get('/users', function() { return view('dashboard.reports.users'); })->name('users');
        Route::get('/locations', function() { return view('dashboard.reports.locations'); })->name('locations');
        Route::get('/analytics', function() { return view('dashboard.reports.analytics'); })->name('analytics');
    });

    // === SYSTEM SETTINGS ===
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function() { return view('dashboard.settings.index'); })->name('index');
        Route::get('/general', function() { return view('dashboard.settings.general'); })->name('general');
        Route::get('/security', function() { return view('dashboard.settings.security'); })->name('security');
        Route::get('/notifications', function() { return view('dashboard.settings.notifications'); })->name('notifications');
        Route::get('/backup', function() { return view('dashboard.settings.backup'); })->name('backup');
    });
});

// Metronic Demo Routes
// Route::get('/', [App\Http\Controllers\Demo1Controller::class, 'index'])->name('home');
// Route::get('/demo1', [App\Http\Controllers\Demo1Controller::class, 'index'])->name('demo1.index');

require __DIR__ . '/auth.php';