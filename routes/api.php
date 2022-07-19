<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::group(['prefix' => 'profile', 'middleware' => 'auth:api'], function () {
    Route::get('/', [\App\Http\Controllers\Api\AbsensiController::class, 'index']);
});

Route::group(['prefix' => 'absen', 'middleware' => 'auth:api'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Api\AbsensiController::class, 'index']);
});
