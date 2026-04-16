<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('todos', TodoController::class);
    Route::apiResource('activity-log', ActivityLogController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('user-categories', UserCategoryController::class);
});