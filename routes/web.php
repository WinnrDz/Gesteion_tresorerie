<?php

use App\Http\Controllers\DashboardController;
use App\Exports\ExcelReport;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DepensenomController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelImportController;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MultiSheetImport;
use Illuminate\Http\Request;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ProfilecvController;
use App\Http\Controllers\SkillController;

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

        Route::resource('candidates', CandidateController::class);
        Route::get('candidates/show/{id}', [CandidateController::class, 'Show'])->name("candidates.show");

        Route::resource('skills', SkillController::class);

        Route::resource('profilecvs', ProfilecvController::class);

        Route::get('/upload', [ExcelController::class, 'showForm'])->name('excel.index');
        Route::post('/upload', [ExcelController::class, 'import'])->name('excel.import');

        Route::post('/export', function (Request $request) {
            $request->validate([
                'year' => 'required|digits:4|integer',
            ]);

            $year = (int) $request->year;

            $export = new ExcelReport($year);

            return $export->download();
        })->name('excel.export');
    });
});

require __DIR__ . '/auth.php';
