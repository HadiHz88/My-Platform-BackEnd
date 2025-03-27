<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/test', function () {
        return response()->json([
            'message' => 'Admin route is working!',
            'timestamp' => now()
        ]);
    });
});
