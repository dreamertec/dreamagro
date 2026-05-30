<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Dashboard Web Routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/mode', [DashboardController::class, 'updateMode'])->name('dashboard.mode');
Route::post('/override', [DashboardController::class, 'toggleOverride'])->name('dashboard.override');
Route::post('/schedules', [DashboardController::class, 'storeSchedule'])->name('dashboard.schedules.store');
Route::delete('/schedules/{schedule}', [DashboardController::class, 'destroySchedule'])->name('dashboard.schedules.destroy');

