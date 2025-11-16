<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('dashboard',DashboardController::class);
Route::resource('depenses',DepenseController::class);