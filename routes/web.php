<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

// Public view-only resource routes (show, index)
Route::get('drivers', [App\Http\Controllers\DriverController::class, 'index'])->name('drivers.index');
Route::get('drivers/{driver}', [App\Http\Controllers\DriverController::class, 'show'])->name('drivers.show');
Route::get('teams', [App\Http\Controllers\TeamController::class, 'index'])->name('teams.index');
Route::get('teams/{team}', [App\Http\Controllers\TeamController::class, 'show'])->name('teams.show');
Route::get('races', [App\Http\Controllers\RaceController::class, 'index'])->name('races.index');
Route::get('races/{race}', [App\Http\Controllers\RaceController::class, 'show'])->name('races.show');
Route::get('races/{id}/qualifying-results', [App\Http\Controllers\RaceController::class, 'qualifyingResults']);

// Admin dashboard and CRUD routes (protected by auth + can:admin)
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::post('admin/race', [App\Http\Controllers\AdminController::class, 'storeRace'])->name('admin.race.store');
    Route::put('admin/race/{id}', [App\Http\Controllers\AdminController::class, 'updateRace'])->name('admin.race.update');
    Route::delete('admin/race/{id}', [App\Http\Controllers\AdminController::class, 'deleteRace'])->name('admin.race.delete');
    
    Route::post('admin/driver', [App\Http\Controllers\AdminController::class, 'storeDriver'])->name('admin.driver.store');
    Route::put('admin/driver/{id}', [App\Http\Controllers\AdminController::class, 'updateDriver'])->name('admin.driver.update');
    Route::delete('admin/driver/{id}', [App\Http\Controllers\AdminController::class, 'deleteDriver'])->name('admin.driver.delete');
    
    Route::post('admin/team', [App\Http\Controllers\AdminController::class, 'storeTeam'])->name('admin.team.store');
    Route::put('admin/team/{id}', [App\Http\Controllers\AdminController::class, 'updateTeam'])->name('admin.team.update');
    Route::delete('admin/team/{id}', [App\Http\Controllers\AdminController::class, 'deleteTeam'])->name('admin.team.delete');
    
    Route::post('admin/sprint-race', [App\Http\Controllers\AdminController::class, 'storeSprintRace'])->name('admin.sprint.store');
    Route::delete('admin/sprint-race/{id}', [App\Http\Controllers\AdminController::class, 'deleteSprintRace'])->name('admin.sprint.delete');
    
    Route::post('admin/qualifying-race', [App\Http\Controllers\AdminController::class, 'storeQualifyingRace'])->name('admin.qualifying.store');
    Route::delete('admin/qualifying-race/{id}', [App\Http\Controllers\AdminController::class, 'deleteQualifyingRace'])->name('admin.qualifying.delete');
    Route::get('admin/qualifying/{id}/results', [App\Http\Controllers\AdminController::class, 'qualifyingResultsForm'])->name('admin.qualifying.results');
    Route::post('admin/qualifying/{id}/results', [App\Http\Controllers\AdminController::class, 'storeQualifyingResults'])->name('admin.qualifying.results.store');
    
    // Standings entry
    Route::get('standings/create', [App\Http\Controllers\StandingController::class, 'create'])->name('standings.create');
    Route::post('standings', [App\Http\Controllers\StandingController::class, 'store'])->name('standings.store');
    Route::get('standings/{id}/edit', [App\Http\Controllers\StandingController::class, 'edit'])->name('standings.edit');
    Route::put('standings/{id}', [App\Http\Controllers\StandingController::class, 'update'])->name('standings.update');
    Route::delete('standings/{id}', [App\Http\Controllers\StandingController::class, 'destroy'])->name('standings.destroy');
});

// Standings public view
Route::get('standings', [App\Http\Controllers\StandingController::class, 'index'])->name('standings.index');
Route::get('standings/{id}', [App\Http\Controllers\StandingController::class, 'show'])->name('standings.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
