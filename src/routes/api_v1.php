<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\OrderController;

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

Route::get(
    '/',
    function () {
        return "Hi";
    }
);

Route::get('/orders', [OrderController::class, 'index']);

Route::get('/testState', [OrderController::class, 'testState']);

Route::prefix('user')->group(
    function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/create', [UserController::class, 'create']);
    }
);

Route::prefix('admin')->group(
    function () {
        Route::post('/login', [AdminController::class, 'login']);
    }
);


Route::group(
    [
        'middleware' => ['jwt_verification:USER','xss']
    ],
    function () {
        Route::post('/order/create', [\App\Http\Controllers\Api\V1\OrderController::class, 'store']);
    }
);

Route::group(
    [
        'middleware' => ['jwt_verification:USER','xss'],
        'prefix' => 'user'
    ],
    function () {
        Route::get('/logout', [UserController::class, 'logout']);
    }
);

Route::group(
    [
        'middleware' => ['jwt_verification:ADMIN','xss'],
        'prefix' => 'admin'
    ],

    function () {
        Route::get('/logout', [AdminController::class, 'logout']);
    }
);
