<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;



Route::post('register',[ApiController::class, 'register']);
Route::post('login',[ApiController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [ApiController::class, 'profile']);
    Route::get('refresh', [ApiController::class, 'refreshToken']);
    Route::get('logout', [ApiController::class, 'logout']);

});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// hello from test branch

// test 2
//test 3
