<?php

namespace App\Http\Requests;

use App\Models\Tag;
use App\Rules\UniqueTagsIdsRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;

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
            'name' => 'sometimes|string|regex:/^([^0-9]*)$/',
            'surname' => 'sometimes|string|regex:/^([^0-9]*)$/',
            'subtitle' => 'sometimes|string',
            'github_url' => 'sometimes|url|max:60|nullable',
            'linkedin_url' => 'sometimes|url|max:60|nullable',
            'about' => 'string|nullable',
            'tags_ids' => ['required', 'array', new UniqueTagsIdsRule(),]
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
