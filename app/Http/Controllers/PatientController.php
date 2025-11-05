<?php

namespace App\Http\Controllers;
use ullinate\contracts\validation\Validator;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;


class PatientController extends Controller
{
        public function PatientRegister(Request $request):?JsonResponse {
        try{
        $patient=Patient::newPatientRegister($request->validate(
            [
                 'nom' => 'required|string|max:255',
                 'antecedant' => 'string|max:1000',
                 'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:patients',
                'telephone' => 'nullable|string|max:20',
            ]
        ));
        if(!$patient){
           return null;
        }
        return response()->json(
            [
                'success'=>true,
                'message'=>'client enregistrer avec success !',
                'patient_id'=>$patient,
            ]
            );
       }catch(\Exception $e){
        return response()->json(
            [
                'success'=>false,
                'message'=>'erreur en enregistement client !',
                'erreur'=>$e->getMessage(),
            ]
            );
       }

    }

    public function PatientProfil($patient_id):JsonResponse {
        try{
        $profil=Patient::newPatientProfil($patient_id);
        if(!$profil){
           return null;
        }
        return response()->json(
            [
                'success'=>true,
                'message'=>'client enregistrer avec success !',
                'patient'=>$profil,
            ]
            );
       }catch(\Exception $e){
        return response()->json(
            [
                'success'=>false,
                'message'=>'erreur de recuperation client !',
                'erreur'=>$e->getMessage(),
            ]
            );
       }

    }
    public function getPatientId(Request $request):JsonResponse{
            try{
              $patient=Patient::newgetPatientId($request->validate(
                [
                     'nom' => 'required|string|max:255',
                     'prenom' => 'required|string|max:255',
                ]
            ));
            }catch(\Exception $e){
              return response()->json(  [
                'success'=>false,
                'message'=>'erreur de recuperation client id !',
                'erreur'=>$e->getMessage(),
              ]);
            }

        return response()->json($patient); 
    }
}
