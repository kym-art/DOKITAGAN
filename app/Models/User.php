<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable implements JWTSubject

{
   use HasFactory  , Notifiable;
   protected $fillable=['user_id','name','surname','grade','email','password'];
   protected $hidden=['password', 'remember_token',];



   protected function casts(){
      return[
         'email_verified_at'=>'datetime',
      ];
   }

   public function getJWTIdentifier(){
      return $this->getKey();
   }
   public function getJWTCustomClaims(){
      return [
         'email'=>$this->email,
         'name'=>$this->name,

      ];

     
   }  

   public static function newregister(array $data):self{

      if(self:: where('email',$data['email'])->exists()){
         return null;
      }
      return self::create([
         'name'=>$data['name'],
         'surname'=>$data['surname'],
         'email'=>$data['email'],
         'password'=>Hash::make($data['password']),
         'grade'=>$data['grade'],

      ]
      );
    

   
   }
   public static function newLogin(array $data): ?int   {
         $user=self::where('email', $data['email'])->first();
         if($user && Hash::check(Hash::make($data['password']) , $user->password)){
            return $user->id;
         }
         return null;
      }


   public function generateAuthToken(): string{
      return JWTAuth::fromUser($this);
   }


public function generateAuthResponse():array{
   $token=$this->generateAuthToken();
   return[
      'access_token'=>$token,
      'token_type'=>'bearer',
      'expires'=>(int) auth()->factory()->getTTL()*60,
      'user'=>[
         'id'=>$this->id,
         'name'=>$this->name,
         'email'=>$this->email,
      ],
   ];



}

public function revokeCurrentToken(): void
    {
        auth()->logout();
    }



public static function refreshAuthToken(): string
    {
        return auth()->refresh();
    }











}
