<?php

namespace App\Http\Requests;

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
            'name' => ['required', 'string', 'regex:/^[^0-9\/?|\\)(*&%$#@!{}\[\]:;="<>]+$/'],
            'surname' => ['required', 'string', 'regex:/^[^0-9\/?|\\)(*&%$#@!{}\[\]:;="<>]+$/'],
            'dni' => ['required', 'unique:users', 'string', 'max:9', 'regex:/^[XYZ]{1}\d{7}[TR]{1}$|^\d{8}[A-Z]{1}$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|regex:/^(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/',
        ];
    }

    public function messages(): array
    {
        return [
            // name
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un texto',
            'name.regex' => 'El nombre no debe contener caracteres especiales',

            // surname
            'surname.required' => 'El apellido es requerido',
            'surname.string' => 'El apellido debe ser un texto',
            'surname.regex' => 'El apellido no debe contener caracteres especiales',

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
            'password.confirmed' => 'La confirmación de la contraseña no coincide',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula y un carácter especial, y tener una longitud mínima de 8 caracteres',
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
