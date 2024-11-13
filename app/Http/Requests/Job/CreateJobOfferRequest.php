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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'skills' => 'nullable|string|max:255',
            'salary' => 'required|string|max:255',
        ];
    }
}
