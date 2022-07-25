<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AdminController;

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

Route::prefix('user')->group(
    function () {
        Route::get('/login', [UserController::class, 'login']);
    }


);

Route::prefix('admin')->group(
    function () {
        Route::get('/login', [AdminController::class, 'login']);
    }
);


Route::group(
    [
        'middleware' => 'jwt_verification',
        'prefix' => 'user'
    ],
    function ($router) {
        Route::get(
            '/test',
            function () {
                return "Hi";
            }
        );
    }
);
