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
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'recruiter_id.required' => 'El camp recruiter_id és obligatori.',
            'recruiter_id.exists' => 'El recruiter_id ha de correspondre a un reclutador existent.',

            'title.required' => 'El camp títol és obligatori.',
            'title.max' => 'El títol no pot tenir més de 255 caràcters.',

            'description.required' => 'El camp descripció és obligatori.',
            'description.max' => 'La descripció no pot tenir més de 255 caràcters.',

            'location.required' => 'El camp ubicació és obligatori.',
            'location.max' => 'La ubicació no pot tenir més de 255 caràcters.',

            'salary.max' => 'El salari no pot tenir més de 255 caràcters.',

            
            
            
        ];
    }
}