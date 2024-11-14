<?php

namespace App\Http\Requests;

use App\Rules\UniqueTagsIdsRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|regex:/^([^0-9]*)$/',
            'surname' => 'sometimes|string|regex:/^([^0-9]*)$/',
            'subtitle' => 'sometimes|string',
            'github_url' => 'sometimes|url|max:60|nullable',
            'linkedin_url' => 'sometimes|url|max:60|nullable',
            'about' => 'string|nullable',
            'tags_ids' => ['sometimes', 'array', new UniqueTagsIdsRule(),]
        ];
    }
}
