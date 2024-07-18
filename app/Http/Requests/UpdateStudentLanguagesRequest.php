<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentLanguagesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'language_name' => 'required|exists:languages,language_name',
            'language_level' => 'required|in:Bàsic,Intermedi,Avançat,Natiu'
        ];
    }
}
