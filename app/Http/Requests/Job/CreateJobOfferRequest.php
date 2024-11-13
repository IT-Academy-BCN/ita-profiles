<?php

declare(strict_types=1);

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobOfferRequest extends FormRequest
{
    /**
     * 
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'recruiter_id' => 'required|uuid|exists:recruiters,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'skills' => 'nullable|string|max:255',
            'salary' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'recruiter_id.required' => 'El camp recruiter_id és obligatori.',
            'title.required' => 'El camp títol és obligatori.',
            'description.required' => 'El camp descripció és obligatori.',
            'location.required' => 'El camp ubicació és obligatori.',
            'salary.required' => 'El camp salari és obligatori.',
        ];
    }
}
