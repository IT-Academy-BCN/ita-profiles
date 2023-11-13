<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class UpdateStudentRequest extends FormRequest
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
            'name' => 'required|string|regex:/^([^0-9]*)$/',
            'surname' => 'required|string|regex:/^([^0-9]*)$/',
            'email'  => 'required|string|email|max:255|unique:users',
            'subtitle' => 'required|string',
            'bootcamp' => 'required|in:Front end Developer,PHP Developer,Java Developer,Nodejs Developer',
            'about' => 'string|nullable',
            'cv' => 'string|max:125|nullable',
            'linkedin' => 'string|url|max:60|nullable',
            'github'=> 'string|url|max:60|nullable',
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