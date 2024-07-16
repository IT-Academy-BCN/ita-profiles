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


	protected function prepareForValidation()
	{
        if(is_array($this->skills) != True)
        {
            throw new HttpResponseException(response()->json(['errors' => "Skills must be an array, empty arrays valid"], 422));
        }

        try{

            $encodedSkills = json_encode($this->skills);
            if ($encodedSkills === false) {
                throw new \Exception(json_last_error_msg());
            }

            $this->merge([
                'skills' => $encodedSkills
            ]);

        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['errors' => $e ], 422));
        }

	}


    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skills' => 'json'
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
