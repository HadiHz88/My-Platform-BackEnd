<?php

use App\Http\Controllers\Dashboard\DashboardProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World!']);
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::resource('projects', DashboardProjectController::class);
    // Add more routes here
});
