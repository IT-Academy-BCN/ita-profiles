<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO Check if here is the correct place to do this
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'regex:/^[^0-9\/?|\\)(*&%$#@!{}\[\]:;_="<>]+$/'],
            'surname' => ['required', 'string', 'regex:/^[^0-9\/?|\\)(*&%$#@!{}\[\]:;_="<>]+$/'],
            'photo' => 'string',
            'status' => 'required|in:Active, Inactive, In a Bootcamp, In a Job',
        ];
    }
    /**
    * If validator fails returns the exception in json form
    *
    * @return array
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            ['errors' => $validator->errors()],
            422
        ));
    }
}
