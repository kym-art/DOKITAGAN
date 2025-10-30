<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable=['nom','prenom','address','email','telephone','sex'];
    
    public static function PatientRegister(array $data):self{

            if (self::where('nom',$data['nom']) -> where('prenom',$data['prenom'])->exists())
                {
                return null;
            }

               $patient = self::create([
                  'nom'=>$data['nom'],
                  'prenom'=>$data['prenom'],
                  'address'=>$data['address'],
                  'email'=>$data['email'],
                  'telephone'=>$data['telephone'],]);
                
                
                  return $patient->id;


}


}
