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

    Route::get('/assigned-to-me', [TaskController::class, 'tasksAssignedToCurrentUser']);


    Route::post('/', [TaskController::class, 'store']);

    Route::put('{task}', [TaskController::class, 'updateTask']);
    Route::put('{task}/status', [TaskController::class, 'updateTaskStatus']);
    Route::put('{task}/dependencies', [TaskController::class, 'addDependencies']);
    Route::put('{task}/assign', [TaskController::class, 'assignTask']);


    Route::get('{task}/details', [TaskController::class, 'showDetails']);
});
