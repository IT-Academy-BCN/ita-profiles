<?php

declare(strict_types=1);

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TagStoreRequest extends FormRequest
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
            'message' => __('Error de validació.'),
            'errors' => $errors,
        ], 422);

        throw new HttpResponseException($response);
    }
}
