<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo1Controller;
use App\Http\Controllers\Demo2Controller;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CurrencyController;

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

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    // Countries
    Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
    Route::get('/countries/{id}/edit', [CountryController::class, 'edit'])->name('countries.edit');
    Route::put('/countries/{id}', [CountryController::class, 'update'])->name('countries.update');

    // Cities
    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('/cities/{id}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{id}', [CityController::class, 'update'])->name('cities.update');

    // Currencies
    Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
    Route::get('/currencies/{id}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
    Route::put('/currencies/{id}', [CurrencyController::class, 'update'])->name('currencies.update');
});

// Demo 1 routes
Route::get('/demo1', function () {
    return view('pages.demo1.index');
});

// Demo 2 routes
Route::get('/demo2', function () {
    return view('pages.demo2.index');
});

// Demo 3 routes
Route::get('/demo3', function () {
    return view('pages.demo3.index');
});

// Demo 4 routes
Route::get('/demo4', function () {
    return view('pages.demo4.index');
});

// Demo 5 routes
Route::get('/demo5', function () {
    return view('pages.demo5.index');
});

// Demo 6 routes
Route::get('/demo6', function () {
    return view('pages.demo6.index');
});

// Demo 7 routes
Route::get('/demo7', function () {
    return view('pages.demo7.index');
});

// Demo 8 routes
Route::get('/demo8', function () {
    return view('pages.demo8.index');
});

// Demo 9 routes
Route::get('/demo9', function () {
    return view('pages.demo9.index');
})->name('demo9.index');

Route::get('/demo9/profile', function () {
    return view('pages.demo9.profile');
})->name('demo9.profile');

// Demo 10 routes
Route::get('/demo10', function () {
    return view('pages.demo10.index');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
});

// Metronic Demo Routes
// Route::get('/', [App\Http\Controllers\Demo1Controller::class, 'index'])->name('home');
// Route::get('/demo1', [App\Http\Controllers\Demo1Controller::class, 'index'])->name('demo1.index');

require __DIR__ . '/auth.php';
