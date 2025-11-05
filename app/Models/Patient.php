<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;




class Patient extends Model
{
    protected $primaryKey="patient_id";
    protected $keytype="int";
    public $incrementing=true;


    protected $fillable=['nom','prenom','address','email','telephone','sex'];
    public static function newPatientProfil($patient_id):?self{
            $patient=Patient::findorfail($patient_id);
            return $patient;
           }
    
    public static function newPatientRegister(array $data):?JsonResponse{


            if (self::where('email',$data['email'] )->exists())
                {
                return null;
                }

               $patient = self::create([
                  'nom'=>$data['nom'],
                  'sex'=>$data['sex'] ?? 'undefine',
                  'nationalite'=>$data['nationalite'] ?? 'Togolaise',
                  'birth_day'=>$data['birth_day'] ?? '00-00-0000',
                  'antecedant'=>$data['antecedant'] ?? 'Aucun',
                  'address'=>$data['address'] ?? 'Lome , Togo',
                  'prenom'=>$data['prenom'],
                  'email'=>$data['email'],
                  'telephone'=>$data['telephone'],
                ]);
                
                
                  return response()->json([
                    'patient'=>$patient,
                  ]) ;




        }
        

        public static function newgetPatientId(array $data):JsonResponse{
            $patient=Patient::where('nom',$data['nom'])->where('prenom',$data['prenom'])->first();
            if(!$patient){
                return response()->json([
                    'success'=>false,
                    'message'=>'Aucun patient trouvé avec ces informations !',
                  ]) ;
            }

            return response()->json(  $patient->patient_id);
        }




  }

