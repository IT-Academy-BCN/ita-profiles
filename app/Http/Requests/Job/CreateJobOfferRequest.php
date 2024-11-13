<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobOfferRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;  // Cambia esto si necesitas validar autorización
    }

    /**
     * Obtén las reglas de validación que se aplicarán a la solicitud.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'skills' => 'nullable|string|max:255',
            'salary' => 'required|string|max:255',
        ];
    }
}
