<?php

use App\Http\Controllers\BotigaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/Home', [BotigaController::class, 'home'])
    ->middleware(['auth', 'verified'])
    ->name('Home');

Route::prefix('botigues')->middleware('auth')->group(function () {
    Route::resource('/', BotigaController::class);  // Esto crea todas las rutas CRUD para botigues
    Route::get('/mapa', [BotigaController::class, 'mapa'])->name('botigues.mapa');
    Route::get('/crearb', [BotigaController::class, 'create'])->name('botigues.crearb');
    Route::post('/botigues', [BotigaController::class, 'store'])->name('botigues.store');
    Route::get('/users', [BotigaController::class, 'users'])->name('botigues.users');
    Route::put('/users/{id}/update-role', [BotigaController::class, 'updateRole'])->name('users.updateRole');
    Route::get('/botigues', [BotigaController::class, 'index'])->name('botigues.index');
    Route::delete('/botigues/{id}', [BotigaController::class, 'destroy'])->name('botigues.destroy');
    Route::get('/editone/{id}', [BotigaController::class, 'editone'])->name('editone');
    Route::put('/botigues/{id}', [BotigaController::class, 'update'])->name('botigues.update');
    Route::get('/botiga/{id}', [BotigaController::class, 'show'])->name('botiga.show');
Route::post('/botigues/{botiga}/afegir-favorit', [BotigaController::class, 'afegirFavorit'])->name('botigues.afegirFavorit');
Route::delete('/botigues/{botiga}/treure-favorit', [BotigaController::class, 'treureFavorit'])->name('botigues.treureFavorit');
    Route::post('/botigues/{botiga}/ressenya', [BotigaController::class, 'guardarRessenya'])
        ->middleware('auth')
        ->name('botigues.ressenya.guardar');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';