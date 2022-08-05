<?php

use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\UserController;
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
Route::prefix('user')->group(
    function (): void {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/create', [UserController::class, 'create']);
    }
);

Route::prefix('admin')->group(
    function (): void {
        Route::post('/login', [AdminController::class, 'login']);
    }
);

Route::group(
    ['middleware' => ['jwt_verification:USER', 'xss']],
    function (): void {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/order/create', [\App\Http\Controllers\Api\V1\OrderController::class, 'store']);
        Route::get('/order/{uuid}/download', [OrderController::class, 'download']);
    }
);

Route::group(
    ['middleware' => ['jwt_verification:USER', 'xss'], 'prefix' => 'user'],
    function (): void {
        Route::get('/logout', [UserController::class, 'logout']);
    }
);

Route::group(
    ['middleware' => ['jwt_verification:ADMIN', 'xss'], 'prefix' => 'admin'],
    function (): void {
        Route::get('/logout', [AdminController::class, 'logout']);
    }
);
