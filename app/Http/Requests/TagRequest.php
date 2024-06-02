<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag_name' => 'required|string|max:75|unique:tags',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => __('La validació ha fallat.'),
            'errors' => $errors,
        ], 422);

        throw new HttpResponseException($response);
    }
}
