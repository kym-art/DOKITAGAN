<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function(){
    Route::post('register',[AuthController::class , 'register']);
    Route::post('login',[AuthController::class , 'login']);

   Route::middleware('jwt')->group(function(){ 
    // Route::post('profile',[AuthController::class , 'profile']);
    // Route::post('logout',[AuthController::class , 'logout']);
    // Route::post('refresh',[AuthController::class , 'refresh']);
    });
});


