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
            'name.required' => 'El nombre de la compañía es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'CIF.required' => 'El CIF es obligatorio.',
            'CIF.unique' => 'Este CIF ya está en uso.',
            'CIF.regex' => 'El formato de CIF no es válido.',
            'location.required' => 'La localización es obligatoria.',
            'website.url' => 'La página web debe contener una URL válida.',
        ];
    }
}
