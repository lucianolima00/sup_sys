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

    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
    Route::post('/client/create', [ClientController::class, 'store'])->name('client.store');
    Route::patch('/client/update', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/delete', [ClientController::class, 'destroy'])->name('client.destroy');

    Route::get('/collaborator', [CollaboratorController::class, 'index'])->name('collaborator.index');
    Route::get('/collaborator/create', [CollaboratorController::class, 'create'])->name('collaborator.create');
    Route::post('/collaborator/create', [CollaboratorController::class, 'store'])->name('collaborator.store');
    Route::patch('/collaborator/update', [CollaboratorController::class, 'update'])->name('collaborator.update');
    Route::delete('/collaborator/delete', [CollaboratorController::class, 'destroy'])->name('collaborator.destroy');
});

require __DIR__.'/auth.php';
