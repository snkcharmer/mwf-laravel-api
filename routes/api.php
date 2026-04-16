<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('todos', TodoController::class);
    Route::apiResource('activity-log', ActivityLogController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('user-categories', UserCategoryController::class);
});