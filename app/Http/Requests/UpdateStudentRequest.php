<?php

namespace App\Http\Requests;

use App\Models\Tag;
use App\Rules\UniqueTagsIdsRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Campos que pueden ser actualizados
     *
     * @var array<string>
     */
    protected $fields = [
        'name',
        'surname',
        'subtitle',
        'github_url',
        'linkedin_url',
        'about',
        'tags_ids',
    ];

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
        $rules = [];
        $requiredWithoutAll = 'required_without_all:' . implode(',', $this->fields);

        foreach ($this->fields as $field) {
            $rules[$field] = match ($field) {
                'name', 'surname' => "nullable|string|regex:/^([^0-9]*)$/|$requiredWithoutAll",
                'subtitle' => "nullable|string|$requiredWithoutAll",
                'github_url', 'linkedin_url' => "nullable|url|max:60|nullable|$requiredWithoutAll",
                'about' => "string|nullable|$requiredWithoutAll",
                'tags_ids' => ['nullable', 'array', new UniqueTagsIdsRule(), $requiredWithoutAll],
                default => "$requiredWithoutAll"
            };
        }

        return $rules;
    }

    /**
     * If validator fails returns the exception in json form
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
