<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('regist', [AuthController::class, 'regist']);

    Route::middleware('auth:api')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::get('user/{id}', [AuthController::class, 'getUser']);
        Route::get('findUser', [AuthController::class, 'getFindUser']);

        Route::get('order/list', [AuthController::class, 'getOrderList']);
        Route::get('order/list/{id}', [AuthController::class, 'getFindOrderList']);

        Route::get('logout', [AuthController::class, 'logout']);
    });
});
