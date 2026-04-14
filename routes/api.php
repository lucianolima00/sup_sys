<?php

use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\CollaboratorApiController;
use App\Http\Controllers\Api\SupportApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $r) => new UserResource($r->user()));

    Route::apiResource('supports', SupportApiController::class);
    Route::apiResource('clients', ClientApiController::class);
    Route::apiResource('collaborators', CollaboratorApiController::class);
    Route::apiResource('users', UserApiController::class);
});
