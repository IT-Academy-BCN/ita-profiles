<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|nullable',
            'company_name' => 'string|nullable',
            'tags' => 'array|nullable',
            'tags.*' => 'string|max:75',
            'github_url' => 'string|url|max:60|nullable',
            'project_url' => 'string|url|max:60|nullable',
        ];
    }
}
