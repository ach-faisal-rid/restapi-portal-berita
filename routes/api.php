<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
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

    // Change Password
    Route::post('/change-password', [UserController::class, 'changePassword']);

    // Update Profile (Change Email, Username, and Profile)
    Route::put('/update-profile', [UserController::class, 'updateProfile']);

    // Post Management
    Route::post('/post', [PostController::class, 'store']);
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::delete('/post/{id}', [PostController::class, 'destroy']);

    // Comment Management
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comment/{id}', [CommentController::class, 'update']);
    Route::delete('/comment/{id}', [CommentController::class, 'destroy']);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/login', [AuthenticationController::class, 'login']);
