<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// User Management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/current', [AuthenticationController::class, 'current']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // Post Management
    Route::post('/posts', [PostController::class, 'store']);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/login', [AuthenticationController::class, 'login']);
