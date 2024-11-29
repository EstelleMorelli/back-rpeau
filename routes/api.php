<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/medias', [MediaController::class, 'list']);

Route::get('/medias/{id}', [MediaController::class, 'find'])->where('id', '[0-9]+');

Route::post('/medias', [MediaController::class, 'create']);

Route::put('/medias/{id}', [MediaController::class, 'update'])->where('id', '[0-9]+');

Route::patch('/medias/{id}', [MediaController::class, 'update'])->where('id', '[0-9]+');

Route::delete('/medias/{id}', [MediaController::class, 'delete'])->where('id', '[0-9]+');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);