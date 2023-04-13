<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [AppController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients/create', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/update/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::patch('/clients/update/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/delete', [ClientController::class, 'destroy'])->name('clients.destroy');

    Route::get('/collaborators', [CollaboratorController::class, 'index'])->name('collaborators.index');
    Route::get('/collaborators/create', [CollaboratorController::class, 'create'])->name('collaborators.create');
    Route::post('/collaborators/create', [CollaboratorController::class, 'store'])->name('collaborators.store');
    Route::get('/collaborators/{id}/update', [CollaboratorController::class, 'edit'])->name('collaborators.edit');
    Route::patch('/collaborators/{id}/update', [CollaboratorController::class, 'update'])->name('collaborators.update');
    Route::delete('/collaborators/{id}/delete', [CollaboratorController::class, 'destroy'])->name('collaborators.destroy');*/
    Route::resource('clients', ClientController::class);
    Route::resource('collaborators', CollaboratorController::class, ['except' => ['update', 'destroy']]);
    Route::any('/collaborators/{collaborator}/update', [CollaboratorController::class, 'update'])->name('collaborators.update');
    Route::any('/collaborators/{collaborator}/delete', [CollaboratorController::class, 'destroy'])->name('collaborators.destroy');
});

require __DIR__.'/auth.php';
