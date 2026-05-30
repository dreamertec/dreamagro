<?php

use App\Http\Controllers\API\IrrigationApiController;
use Illuminate\Support\Facades\Route;

// Irrigation API endpoints
Route::prefix('irrigation')->group(function () {
    Route::get('/status', [IrrigationApiController::class, 'status']);
    Route::post('/telemetry', [IrrigationApiController::class, 'telemetry']);
    Route::post('/log', [IrrigationApiController::class, 'logEvent']);
});

