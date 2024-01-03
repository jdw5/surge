<?php

use Laravel\Fortify\RoutePath;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginIndexController;
use App\Http\Controllers\Auth\ResetIndexController;
use App\Http\Controllers\Auth\RecoverIndexController;
use App\Http\Controllers\Auth\RegisterIndexController;
use App\Http\Controllers\Auth\TwoFactorIndexController;

Route::get('/auth/register', RegisterIndexController::class)->name('auth.register');
Route::get('/auth/login', LoginIndexController::class)->name('auth.login');
Route::get('auth/two-factor', TwoFactorIndexController::class)->name('auth.two-factor');
Route::get('auth/recover', RecoverIndexController::class)->name('auth.recover');
Route::get('auth/reset', ResetIndexController::class)->name('password.reset');

Route::get(RoutePath::for('password.confirm', '/user/confirm-password'), [ConfirmablePasswordController::class, 'show'])
    ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')]);


Route::get(RoutePath::for('two-factor.login', '/two-factor-challenge'), [TwoFactorAuthenticatedSessionController::class, 'create'])
    ->middleware(['guest:'.config('fortify.guard')])
    ->name('two-factor.login');


Route::get(RoutePath::for('verification.notice', '/email/verify'), EmailVerificationPromptController::class, '__invoke')
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('verification.notice');
