<?php
declare(strict_types=1);

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
            'username.required' => 'The username is required',
            'username.string' => 'The username must be a text',
            'username.min' => 'The username must have at least 3 characters',

            // dni
            'dni.required' => 'dni is required',
            'dni.unique' => 'dni allready exist',
            'dni.string' => 'dni must be a text',
            'dni.max' => 'dni no debe ser mayor a :max caracteres',
            'dni.regex' => 'dni must not contain special characters',

            // email
            'email.email' => 'It must have an email format',
            'email.required' => 'Email is required',
            'email.string' => 'The email must be a text',
            'email.max' => 'The email must not exceed :max characters',
            'email.unique' => 'The email allready exist',

            // password
            'password.required' => 'The password is required',
            'password.confirmed' => 'The password confirmation does not match',
            'password.regex' => 'The password must contain at least one capital letter and one special character, and have a minimum length of 8 characters',

            // specialization
            'specialization.required' => 'The specialty is required',
            'specialization.in' => 'The specialty is not validated',

            // terms
            'terms.required' => 'You must accept the terms and conditions',
            'terms.in' => 'You must accept the terms and conditions',
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
