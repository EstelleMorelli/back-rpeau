<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\AuthMiddleware;

// Routes publiques accessibles sans authentification
Route::get('/medias', [MediaController::class, 'list']);
Route::get('/medias/{id}', [MediaController::class, 'find'])->where('id', '[0-9]+');

// Routes protégées par JWT Auth
Route::middleware('jwt.auth')->group(function () {
    // Routes POST, PUT, PATCH et DELETE protégées
    Route::post('/medias', [MediaController::class, 'create']);
    Route::put('/medias/{id}', [MediaController::class, 'update'])->where('id', '[0-9]+');
    Route::patch('/medias/{id}', [MediaController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/medias/{id}', [MediaController::class, 'delete'])->where('id', '[0-9]+');

    // Route pour récupérer l'utilisateur connecté
    Route::get('/me', [AuthController::class, 'me'])->name('me');

    // Route pour déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Routes pour l'authentification accessibles aux invités
Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

// Routes pour la gestion des utilisateurs
Route::apiResource('users', UserController::class);
