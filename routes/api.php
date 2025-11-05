<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\jwtAuthenticate;
use App\Http\Controllers\PatientController;

Route::prefix('auth')->group(function()

{
    Route::post('register',[AuthController::class , 'register']);
    Route::post('login',[AuthController::class , 'login']);

    Route::post('refresh',[AuthController::class , 'refresh'])->middleware('refresh');
    
    Route::middleware('Gate')->group(function(){ 
    Route::post('profil/{user_id}',[AuthController::class , 'profil']);
    // Route::post('logout',[AuthController::class , 'logout']);
    });
});

Route::prefix('patient')->group(function(){
    
    Route::middleware('Gate')->group(function(){ 
    Route::post('register', [PatientController::class,'PatientRegister']);
    Route::post('profil/{patient_id}', [PatientController::class,'PatientProfil']);
    Route::post('findId', [PatientController::class,'getPatientId']);
    });
   

});
