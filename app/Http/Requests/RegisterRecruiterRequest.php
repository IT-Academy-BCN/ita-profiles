<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DniNieRule;

class RegisterRecruiterRequest extends FormRequest
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
            'dni' => ['required', 'string', 'max:9', 'unique:users', new DniNieRule()],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|regex:/^(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/',
            'company_id' => 'sometimes|exists:companies,id',
            'terms' => 'required|accepted',
        ];
    }
}
