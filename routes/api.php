<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'users'], function () {
        Route::post('/', App\Http\Controllers\User\StoreController::class);
});

Route::group(['prefix' => 'cities'], function () {
        Route::get('/', App\Http\Controllers\City\IndexController::class);
});

Route::group(['prefix' => 'blood_groups'], function () {
        Route::get('/', App\Http\Controllers\BloodGroup\IndexController::class);
});

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
     Route::group(['middleware' => 'jwt.auth'], function () {
        Route::group(['prefix' => 'fruits'], function () {
            Route::get('/', App\Http\Controllers\Fruit\IndexController::class);
        });
    });
});

Route::group(['prefix' => 'stations'], function () {
    Route::get('/', App\Http\Controllers\Station\IndexController::class);
});


