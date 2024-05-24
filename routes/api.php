<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::get('/userProfile', [AuthController::class, 'userProfile']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/hello', function(){ return response()->json(["message" => "Hello world!"], 200); });

});

Route::get('/users', [AuthController::class, 'allUsers']);

