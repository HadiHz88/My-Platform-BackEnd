<?php

use App\Http\Controllers\Admin\AdminAuthController;
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




Route::prefix('admin')->group(function () {
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/test',[AdminAuthController::class, 'test']);

    Route::middleware('auth.admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/user', [AdminAuthController::class, 'user']);
    });
});
