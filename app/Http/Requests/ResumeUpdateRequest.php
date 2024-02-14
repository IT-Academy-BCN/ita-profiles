<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeUpdateRequest extends FormRequest
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
            'subtitle'=>'|string',
            'linkedin_url'=>'url', 
            'github_url'=>'url', 
            'specialization'=>'string|in:Frontend, Backend, Fullstack, Data Science, Not Set',
        ];
    }
}
