<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>[
                'required','string','max:255','min:2',
            ],
            'surname'=>[
                'string','max:255',
            ],
            'grade'=>[
                'string','max:255',
            ],
            'email'=>[
                'required','string','email','max:255','unique:users,email',
            ],
             'password' => [
                'required',
                'string',
                'min:8',         // Minimum 8 caractères
                'confirmed',     // Doit correspondre à password_confirmation
            ],
        ];
    }

    protected function failedvalidation(Validator $validator){
       
           return response()->json([
                'success'=>false,
                'message'=>'erreur de avlidation',
                'errors'=>$validator->errors()
            ],422);
       
    }
}
