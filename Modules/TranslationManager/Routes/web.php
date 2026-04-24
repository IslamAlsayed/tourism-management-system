<?php

use Illuminate\Support\Facades\Route;

Route::prefix('dashboard/translation-manager')->name('dashboard.translation-manager.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return app(\Modules\TranslationManager\Livewire\TranslationManager::class)();
    })->name('index');
});
