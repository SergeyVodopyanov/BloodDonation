<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/{page}', App\Http\Controllers\IndexController::class)->where('page', '.*');