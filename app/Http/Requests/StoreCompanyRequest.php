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
            'name.required' => 'Company name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'CIF.required' => 'CIF is required.',
            'CIF.unique' => 'The CIF is already in use.',
            'CIF.regex' => 'Enter a valid CIF.',
            'location.required' => 'Location is required.',
            'location.min' => 'Location must have at least :min characters.',
            'website.url' => 'Enter a valid website.',
        ];
    }
}
