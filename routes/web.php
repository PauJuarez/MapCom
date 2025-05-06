<?php

use App\Http\Controllers\BotigaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Home', function () {
    return view('Home');
})->middleware(['auth', 'verified'])->name('Home');

Route::prefix('botigues')->middleware('auth')->group(function () {
    Route::resource('/', BotigaController::class);  // Esto crea todas las rutas CRUD para botigues
    Route::get('/mapa', [BotigaController::class, 'mapa'])->name('botigues.mapa');
    Route::get('/botigues', [BotigaController::class, 'mapa'])->name('botigues.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';