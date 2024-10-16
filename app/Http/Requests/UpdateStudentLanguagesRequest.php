<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentLanguagesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|exists:languages,name',
            'level' => 'required|in:Bàsic,Intermedi,Avançat,Natiu'
        ];
    }
}
