<?php

use App\Http\Controllers\CustomerController;
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

Route::group([
    'prefix' => 'v1'
], function ($router) {
    Route::post('/login', [UserController::class, 'login']) -> name('login');
    Route::post('/register', [UserController::class, 'register']) -> name('register');

    Route::middleware('auth:sanctum')->group(function($router) {
        Route::apiResource('customer', CustomerController::class);
    });
});