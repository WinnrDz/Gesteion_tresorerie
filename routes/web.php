<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DepenseNomController;
use App\Http\Controllers\EntreeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('dashboard',DashboardController::class);

Route::resource('depenses',DepenseController::class);

Route::resource('depensesNoms',DepenseNomController::class);

Route::resource('entrees',EntreeController::class);