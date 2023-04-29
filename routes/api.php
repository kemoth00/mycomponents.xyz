<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComponentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/', [AuthController::class, 'show']);
    });
});

Route::prefix('/components')->group(function () {
    Route::get('/popular', [ComponentController::class, 'popular']);
    Route::get('/newest', [ComponentController::class, 'newest']);
    Route::post('/search', [ComponentController::class, 'search']);
    Route::get('/{component:uuid}', [ComponentController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/upvote/{component:uuid}', [ComponentController::class, 'upvote']);
        Route::get('/downvote/{component:uuid}', [ComponentController::class, 'downvote']);
        Route::post('/', [ComponentController::class, 'store']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
