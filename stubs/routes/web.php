<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeIndexController;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginIndexController;
use App\Http\Controllers\Auth\ResetIndexController;
use App\Http\Controllers\Auth\RecoverIndexController;
use App\Http\Controllers\Auth\RegisterIndexController;
use App\Http\Controllers\Auth\TwoFactorIndexController;

Route::get('/', HomeIndexController::class)->name('home.index');
// Route::get('/dashboard', DashboardController::class)->name('dashboard');

Route::get('/auth/register', RegisterIndexController::class)->name('auth.register');
Route::get('/auth/login', LoginIndexController::class)->name('auth.login');

Route::get('auth/two-factor', TwoFactorIndexController::class)->name('auth.two-factor');


Route::get('auth/recover', RecoverIndexController::class)->name('auth.recover');
Route::get('auth/reset', ResetIndexController::class)->name('password.reset');

require __DIR__ . '/auth.php';