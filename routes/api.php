<?php

use App\Http\Controllers\Dashboard\DashboardProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World!']);
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/projects', [DashboardProjectController::class, 'index']);
    Route::get('/projects/{project}', [DashboardProjectController::class, 'show']);
    Route::post('/projects', [DashboardProjectController::class, 'store']);
    Route::put('/projects/{project}', [DashboardProjectController::class, 'update']);
    Route::delete('/projects/{project}', [DashboardProjectController::class, 'destroy']);
});
