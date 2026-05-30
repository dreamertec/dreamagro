<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Temporary route to force clear server cache
Route::get('/clear', function() {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return 'Laravel cache cleared successfully!';
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Dashboard Web Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/mode', [DashboardController::class, 'updateMode'])->name('dashboard.mode');
    Route::post('/override', [DashboardController::class, 'toggleOverride'])->name('dashboard.override');
    Route::post('/schedules', [DashboardController::class, 'storeSchedule'])->name('dashboard.schedules.store');
    Route::delete('/schedules/{schedule}', [DashboardController::class, 'destroySchedule'])->name('dashboard.schedules.destroy');
    Route::put('/schedules/{schedule}', [DashboardController::class, 'updateSchedule'])->name('dashboard.schedules.update');
});

