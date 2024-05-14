<?php

namespace App\Http\Requests;

use App\Rules\DniNieRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'username' => ['required', 'string', 'min:3'],
            'dni' => ['required', 'unique:users', 'string', 'max:9', new DniNieRule()],
            'email' => 'required|string|email|max:255|unique:users',
            'specialization' => 'required|in:Frontend,Backend,Fullstack,Data Science,Not Set',
            'password' => 'required|confirmed|string|regex:/^(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/',
            'terms' =>  'required|in:true' 
        ];
    }

    public function messages(): array
    {
        return [
            // username
            'username.required' => 'El username es requerido',
            'username.string' => 'El username debe ser un texto',
            'username.min' => 'El username debe tener al menos 3 caracteres',

            // dni
            'dni.required' => 'El dni es requerido',
            'dni.unique' => 'El dni ya existe',
            'dni.string' => 'El dni debe ser un texto',
            'dni.max' => 'El dni no debe ser mayor a :max caracteres',
            'dni.regex' => 'El dni no debe contener caracteres especiales',

            // email
            'email.required' => 'El email es requerido',
            'email.string' => 'El email debe ser un texto',
            'email.max' => 'El email no debe ser mayor a :max caracteres',
            'email.unique' => 'El email ya existe',

            // password
            'password.required' => 'La contraseña es requerida',
            'password.confirmed' => 'La confirmacion de la contraseña no coincide',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula y un carácter especial, y tener una longitud minima de 8 caracteres',

            // specialization
            'specialization.required' => 'La especialidad es requerida',
            'specialization.in' => 'La especialidad no es valida',

            // terms
            'terms.required' => 'Debes aceptar los terminos y condiciones',
            'terms.in' => 'Debes aceptar los terminos y condiciones',
        ];
    }

    /**
     * If validator fails returns the exception in json form
     *
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
