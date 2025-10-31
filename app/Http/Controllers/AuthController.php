<?php

namespace App\Http\Controllers;
use ullinate\contracts\validation\Validator;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller{
public function register(RegisterRequest $request):JsonResponse{
  try{
    $user=User::newregister($request->validated());
    $authresponse=$user->generateAuthResponse();

    return response()->json([
        'success'=>true,
        'message'=>'register sucess',
        'data'=>$authresponse,
    ] , 201);
  }catch(\Exception $e){ 

    return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'inscription',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

public function login(LoginRequest $request):JsonResponse{
    try{
     $user=User::newlogin($request->validated());
     if(!$user){
        return response()->json( [
            'success' => false,
            'message' => 'Identifiants invalides',
        ], 401);
     }
     $data=$user->generateAuthResponse();

        return response()->json([
            'success' => true,
            'message' => 'login success', 
            'data'=>$data,
        ],201);
     
    }catch(\Exception $e){
       return response()->json(
        [
            'success' => false,
            'message' => 'Erreur lors du login',
            'error' => $e->getMessage(),
            ], 500);
       
    }
  
}
public function refresh():?string{
    $refreshedtoken=User::refreshAuthToken();
    if($refreshedtoken){
        return $refreshedtoken;
    }
return null;
}
}
  
