<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('test', function () {
    $projects = \App\Models\Project::with(['tags', 'likes', 'views'])->get();
    return Inertia::render('test', [
        'projects' => $projects,
    ]);
})->name('test');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// My Implementation
Route::prefix('dashboard')->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('entries', EntryController::class);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
