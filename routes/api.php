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

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
