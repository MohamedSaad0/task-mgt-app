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
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'tasks'], function () {
    Route::get('/', [TaskController::class, 'index']);

    Route::get('/user', [TaskController::class, 'show']);


    Route::post('tasks', [TaskController::class, 'store']);

    Route::put('{task}', [TaskController::class, 'updateTask']);
    Route::put('{task}/status', [TaskController::class, 'updateTaskStatus']);
    Route::post('{task}/dependencies', [TaskController::class, 'addDependencies']);

    Route::get('{task}/details', [TaskController::class, 'showDetails']);
})->middleware('auth:sanctum');
