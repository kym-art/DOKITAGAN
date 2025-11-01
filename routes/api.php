<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function()
{
    Route::post('register',[AuthController::class , 'register']);
    Route::post('login',[AuthController::class , 'login']);

   Route::middleware('jwt')->group(function(){ 

   
    Route::post('refresh',[AuthController::class , 'refresh']);
    Route::post('profil/{user_id}',[AuthController::class , 'profil']);
    // Route::post('logout',[AuthController::class , 'logout']);
    });
});


