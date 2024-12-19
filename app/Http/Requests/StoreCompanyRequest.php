<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:companies,email',
            'CIF' => [
                'required',
                'string',
                'regex:/^(^[A-Z][0-9]{7}[A-Z0-9]$)|(^[0-9]{8}[A-Z]$)|(^[XYZ][0-9]{7}[A-Z])$/',
                'max:10',
                'unique:companies,CIF',
            ],
            'location' => 'required|string|min:3|max:255',
            'website' => 'nullable|url|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The company name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'CIF.required' => 'The CIF is required.',
            'CIF.unique' => 'This CIF is already in use.',
            'CIF.regex' => 'The CIF format is invalid.',
            'location.required' => 'The location is required.',
            'website.url' => 'The website must contain a valid URL.',
        ];
    }
}
