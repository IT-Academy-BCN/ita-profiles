<?php

namespace App\Http\Requests\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TagUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $tagId = $this->route('tagId');
        if (Tag::find($tagId)) {
            return [
                'tag_name' => 'required|string|max:75|unique:tags,tag_name,' . $tagId,
            ];
        }
        return [];
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
