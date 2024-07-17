<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class CollaborationsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Convert empty value to null
        $this->merge([
            'collaborations' => array_map(function ($item) {
                return $item === '' ? null : $item;
            }, $this->collaborations ?? [])
        ]);
    }

    public function rules(): array
    {
        return [
            'collaborations' => 'required|array|size:2',
            'collaborations.*' => 'nullable|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
