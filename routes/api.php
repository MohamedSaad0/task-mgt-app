<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/user', [TaskController::class, 'show']);
})->middleware('auth:sanctum');
