<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentLanguagesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'languages' => 'required|array',
            'languages.*.language_name' => 'required|string',
            'languages.*.language_level' => 'required|in:Bàsic,Intermedi,Avançat,Natiu',
        ];
    }
}
