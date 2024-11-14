<?php

declare(strict_types=1);

namespace App\Http\Requests\Job;

use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobOfferRequest extends FormRequest
{
    protected $container;

    public function __construct(Container $container)
    {
        parent::__construct();
        $this->container = $container; 
    }

    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'recruiter_id' => 'required|exists:recruiters,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'skills' => 'nullable|string',
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
