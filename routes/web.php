<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| All authenticated routes are served by the React SPA. Laravel Breeze
| auth routes (login, register, forgot-password, etc.) remain as Blade.
|
*/

require __DIR__.'/auth.php';

// Serve the React SPA for all authenticated routes.
// Route::fallback always runs last, so explicit routes (login, etc.) are never shadowed.
Route::fallback(fn() => view('spa'))->middleware('auth');
