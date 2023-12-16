<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\AdminManager;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Users\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Get user using access token
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout user
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admins management routes
    Route::apiResource('admins', AdminManager::class)->except(['update']);

    // Users management routes
    Route::apiResource('users', UserController::class);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/new-user', [AuthController::class, 'register']);
