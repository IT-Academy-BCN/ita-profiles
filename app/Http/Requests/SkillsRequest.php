<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\DniNieRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SkillsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skills' => 'array'
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
