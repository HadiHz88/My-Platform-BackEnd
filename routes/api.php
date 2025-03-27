<?php

use App\Http\Controllers\Dashboard\DashboardBlogController;
use App\Http\Controllers\Dashboard\DashboardProjectController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World!']);
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::resource('projects', DashboardProjectController::class);
    Route::resource('blogs', DashboardBlogController::class);
});

Route::get('/home', [HomeController::class, "index"]);
