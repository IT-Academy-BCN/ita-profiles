<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'dni' => ['required', 'regex:/^[0-9]{8}[A-Z]$/', 'unique:users'],
            'email' => 'required|string|email|max:255|unique:users',
            'specialization' => 'required|in:Frontend,Backend,Fullstack,Data Science,Not Set',
            'password' => 'required|confirmed|string|regex:/^(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/',
            'terms' =>  'required|in:true'
        ];
    }
}
