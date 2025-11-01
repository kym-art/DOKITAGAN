<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authentificate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next):JsonResponse
    {
        try{
           $user=JWTAuth::parseToken()->autenticate();

           if(!$user){
            return response()->json([ 
            'success' => false,
            'message' => 'Utilisateur non trouvé',]);}
        }catch (TokenExpiredException $e) {
       
        }catch(\Exception $e){
             return response()->json([
                'success' => false,
                'message' => 'Token expiré',
                'error' => $e->getMessage(),
            ]);
        }

        return $next($request);
    }

    }

