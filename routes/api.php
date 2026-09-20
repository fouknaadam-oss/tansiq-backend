<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

// Everything inside this group REQUIRES a valid token
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', function () {
        return \App\Models\User::select('id', 'name', 'email')->get();
    });
    // Get current user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Secure Units & Tasks routes
    Route::apiResource('units', UnitController::class);
    Route::apiResource('tasks', TaskController::class);
    
});