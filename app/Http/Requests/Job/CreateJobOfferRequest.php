<?php

declare(strict_types=1);

namespace App\Http\Requests\Job;

use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Redirector;


class CreateJobOfferRequest extends FormRequest
{
    protected $container;
    protected $redirector;

    public function __construct(Container $container, Redirector $redirector)
    {
        parent::__construct();
        $this->container = $container;
        $this->redirector = $redirector;
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
            'salary' => 'required|numeric|min:0',
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
