<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeIndexController;
use App\Http\Controllers\DashboardIndexController;

Route::get('/', HomeIndexController::class)->name('home.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardIndexController::class)->name('dashboard.index');
});

require __DIR__ . '/auth.php';