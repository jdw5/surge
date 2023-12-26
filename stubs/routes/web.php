<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeIndexController;

Route::get('/', HomeIndexController::class)->name('home.index');