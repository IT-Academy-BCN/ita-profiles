<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentLanguagesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'language_id' => 'required|exists:languages,id',
            'language_level' => 'required|string'
        ];
    }
}
