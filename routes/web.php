<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DepensenomController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::resource('dashboard', DashboardController::class)->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['admin'])->group(function () {
        Route::resource('depenses', DepenseController::class);
        Route::get('/depenses/{id}/download', [DepenseController::class, 'download'])->name("depenses.download");
    
        Route::resource('depensesNoms', DepenseNomController::class);
    
        Route::resource('entrees', EntreeController::class);
        Route::get('/entrees/{id}/download', [EntreeController::class, 'download'])->name("entrees.download");
    
        Route::resource('clients', ClientController::class);
    
        Route::resource('projects', ProjectController::class);
    });

});

require __DIR__ . '/auth.php';
