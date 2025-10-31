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
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

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
   public static function newLogin(array $data): ?self   {
         $user=self::where('email', $data['email'])->first();
         if(!($user && Hash::check($data['password'] , $user->password))){
            return null;
         }
         return $user;
      }
   public function generateAuthToken(): string{
      if(!$this->user_id){
         throw new \Exception('impossible de generer le token ; Utilisateur id not found');
      }
      return JWTAuth::fromUser($this);
   }


public function generateAuthResponse():array{
   $token=$this->generateAuthToken();
   return[
      'access_token'=>$token,
      'token_type'=>'bearer',
      'expires'=>(int) auth()->factory()->getTTL()*60,
      'user'=>[
         'id'=>$this->user_id,
         'name'=>$this->name,
         'email'=>$this->email,
      ],
   ];



}

public function revokeCurrentToken(): void
    {

    }

public static function refreshAuthToken(): ?string
    { 
      try{
       $newtoken=Auth()->refresh();
       return [
         "sucess"=>true,
         'access_token'=>$newtoken,
         'token_type'=>'bearer',
         'expires'=>(int) auth()->factory()->getTTL()*60,   
       ];



    }catch(\Exception $e){
      return reponse()->json(
         [
         'success' => false,
         'message' => 'Erreur lors du rafraîchissement du token',
         'error' => $e->getMessage(),
         ]);

    }

    } 











}
