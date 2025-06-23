<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisplayController;

// Ruta pública para login
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas por JWT
Route::middleware('auth:api')->group(function () {
    // CRUD de pantallas
    Route::apiResource('displays', DisplayController::class);

    // Perfil del usuario autenticado
    Route::get('/me', [AuthController::class, 'me']);

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);

    // Refresh del token
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
