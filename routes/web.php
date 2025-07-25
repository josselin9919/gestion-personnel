<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonnelTemporaireController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\CritereEvaluationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Personnel routes
    Route::resource('personnel', PersonnelTemporaireController::class);

    // Evaluation routes
    Route::resource('evaluations', EvaluationController::class);
    Route::get('/personnel/{personnel}/historique', [EvaluationController::class, 'historique'])->name('personnel.historique');

    // Critères routes
    Route::resource('criteres', CritereEvaluationController::class);
    Route::patch('/criteres/{critere}/toggle-actif', [CritereEvaluationController::class, 'toggleActif'])->name('criteres.toggle-actif');

    // Export routes
    Route::get('/export/excel', function() { return response()->json(['message' => 'Export Excel en cours de développement']); })->name('export.excel');
    Route::get('/export/pdf/{id}', function($id) { return response()->json(['message' => 'Export PDF en cours de développement']); })->name('export.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
