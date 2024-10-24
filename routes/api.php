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
Route::group(['prefix' => 'bloodDonations'], function () {
    Route::post('/', App\Http\Controllers\BloodDonation\StoreController::class);
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
        Route::get('user', [AuthController::class, 'getUser']);
        Route::get('user/{user_id}/donations', [App\Http\Controllers\User\UserController::class, 'getUserDonations']);
    });
});

// Route::get('/user/{user_id}/donations', [App\Http\Controllers\User\UserController::class, 'getUserDonations']);

Route::group(['prefix' => 'stations'], function () {
    Route::get('/', App\Http\Controllers\Station\IndexController::class);
    Route::get('/{id}', App\Http\Controllers\Station\ShowController::class);
});

Route::group(['prefix' => 'points'], function () {
    Route::get('/', [App\Http\Controllers\Point\PointController::class, 'index']);
    Route::get('/{id}', [App\Http\Controllers\Point\PointController::class,'show']);
    Route::get('/{id}/available_times', [App\Http\Controllers\Point\PointController::class,'getAvailableTimes']);

});

Route::post('/donations', [App\Http\Controllers\Donation\DonationController::class, 'store']);


