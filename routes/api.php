<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\Qvsapireq;
use App\Http\Controllers\Qvshealthstate;
use App\Http\Controllers\Qvsimccontroll;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::get('/userProfile', [AuthController::class, 'userProfile']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/userdata', [CorreoController::class, 'login']);

    Route::post('/results', [Qvsapireq::class, 'store']);

    Route::post('/imcval', [Qvsimccontroll::class, 'other']);

    Route::post('/healthstateval', [Qvshealthstate::class, 'mine']);

});

Route::get('/users', [AuthController::class, 'allUsers']);

