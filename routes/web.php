<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DepenseNomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('dashboard',DashboardController::class);

Route::resource('depenses',DepenseController::class);

Route::resource('depensesNoms',DepenseNomController::class);