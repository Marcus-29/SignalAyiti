<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SignalementController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/stats/public', [DashboardController::class, 'publicStats']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/signalements', [SignalementController::class, 'index']);
    Route::post('/signalements', [SignalementController::class, 'store']);
    Route::get('/signalements/{signalement}', [SignalementController::class, 'show']);
    Route::delete('/signalements/{signalement}', [SignalementController::class, 'destroy']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{notification}/lu', [NotificationController::class, 'markAsRead']);

    Route::middleware('agent')->group(function () {
        Route::put('/signalements/{signalement}/statut', [SignalementController::class, 'updateStatut']);
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    });
});
