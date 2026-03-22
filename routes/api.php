<?php

use App\Http\Controllers\Api\AbsenceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\FormateurController;
use App\Http\Controllers\Api\FormationController;
use App\Http\Controllers\Api\InscritController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\ThemeController;
use Illuminate\Support\Facades\Route;

// Public Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth profile & logout
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);

    // Resource API Routes
    Route::apiResource('themes', ThemeController::class);
    Route::apiResource('formations', FormationController::class);
    Route::apiResource('sessions', SessionController::class)->except(['update']);
    Route::apiResource('participants', ParticipantController::class)->except(['show', 'update']);
    Route::apiResource('absences', AbsenceController::class)->except(['show', 'update']);
    Route::apiResource('documents', DocumentController::class)->except(['show', 'update']);
    Route::apiResource('inscrits', InscritController::class);
    Route::apiResource('formateurs', FormateurController::class);
    Route::apiResource('traitements', \App\Http\Controllers\Api\TraitementController::class);

    // Notification routes
    Route::get('/notifications', [\App\Http\Controllers\Api\NotificationController::class, 'index']);
    Route::get('/notifications/unread', [\App\Http\Controllers\Api\NotificationController::class, 'unread']);
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Api\NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [\App\Http\Controllers\Api\NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [\App\Http\Controllers\Api\NotificationController::class, 'destroy']);
});
