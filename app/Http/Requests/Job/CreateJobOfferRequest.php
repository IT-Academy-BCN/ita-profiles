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
            'company_id' => 'required|exists:companies,id',
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
            'recruiter_id.required' => 'The recruiter_id field is required.',
            'recruiter_id.exists' => 'The recruiter_id must correspond to an existing recruiter.',

            'company_id.required' => 'The company_id field is required.',
            'company_id.exists' => 'The company_id must correspond to an existing company.',

            'title.required' => 'The title field is required.',
            'title.max' => 'The title cannot exceed 255 characters.',

            'description.required' => 'The description field is required.',
            'description.max' => 'The description cannot exceed 255 characters.',

            'location.required' => 'The location field is required.',
            'location.max' => 'The location cannot exceed 255 characters.',

            'salary.max' => 'The salary cannot exceed 255 characters.',

            'skills.max' => 'Skills cannot exceed 255 characters.',


        ];
    }
}
