<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('test', function () {
    $projects = \App\Models\Project::with(['tags', 'likes', 'views'])->get();
    $tags = \App\Models\Tag::all();
    return Inertia::render('test', [
        'projects' => $projects,
        'tags' => $tags,
    ]);
})->name('test');

// My Implementation
Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('entries', EntryController::class);
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
