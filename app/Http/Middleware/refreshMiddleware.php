<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class refreshMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{

            
           $user=JWTAuth::parseToken()->authenticate();
              if(!$user){
            return response()->json([ 
            'success' => false,
            'message' => 'Utilisateur non trouvé',]);}
            }catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalide',
                'error' => $e->getMessage(),
            ]);
        
           }catch(\Exception $e){
             return response()->json([
                'success' => false,
                'message' => 'authentification échouée',
                'error' => $e->getMessage(),
            ]);
        }
        return $next($request);
    }
}
