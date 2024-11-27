<?php

declare(strict_types=1);

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Job\CreateJobOfferRequest;
use Symfony\Component\Console\Input\InputArgument;
use App\Http\Controllers\Api\Job\JobOfferController;

class CreateJobOfferCommand extends Command
{

    protected $description = 'Create a new job offer in the database giving the required arguments step by step in terminal.' . PHP_EOL . '  Example:
    Recruiter ID: 9d848076-df53-4430-bdd8-3cc1474d4b1e
    Title: Senior Backend Developer
    Description: Looking for an experienced Backend Developer
    Location: Barcelona
    Salary: 55000
    Skills: PHP, Laravel, MySQL, MongoDB (Optional)';

    protected $jobOfferController;
   
    public function __construct(JobOfferController $jobOfferController)
    {
        parent::__construct();
        $this->jobOfferController = $jobOfferController;
    }
    
    protected function configure()
    {
        $this->setName('job:offer:create')
            ->addArgument('recruiter_id', InputArgument::OPTIONAL, 'The ID of the recruiter')
            ->addArgument('title', InputArgument::OPTIONAL, 'The title of the job offer')
            ->addArgument('description', InputArgument::OPTIONAL, 'The description of the job offer')
            ->addArgument('location', InputArgument::OPTIONAL, 'The location of the job offer')
            ->addArgument('salary', InputArgument::OPTIONAL, 'The salary for the job offer')
            ->addArgument('skills', InputArgument::OPTIONAL, 'The skills required for the job offer (Optional)');
    }

    public function handle()
       {
        try {
            $data = $this->askJobOfferData();
            $request = $this->createRequest($data);

            $response = $this->jobOfferController->createJobOffer($request);

            $this->handleResponse($response);

            return 0;
        } catch (ValidationException $e) {
            $this->handleValidationException($e);
            return 1;
        }
    }

    protected function askJobOfferData(): array
    {
        return [
            'recruiter_id' => $this->argument('recruiter_id') ?? $this->ask('Introdueix l\'ID del reclutador'),
            'title' => $this->argument('title') ?? $this->ask('Introdueix el títol de l\'oferta'),
            'description' => $this->argument('description') ?? $this->ask('Introdueix la descripció de l\'oferta'),
            'location' => $this->argument('location') ?? $this->ask('Introdueix la ubicació'),
            'salary' => $this->argument('salary') ?? $this->ask('Introdueix el salari'),
            'skills' => $this->argument('skills') ?? $this->ask('Introdueix les habilitats requerides (opcional, separades per comes)')
        ];
    }
    protected function createRequest(array $data): CreateJobOfferRequest
    {
        $request = new CreateJobOfferRequest(app(), app('redirect'));
        
        if (empty($data['skills'])) {
            unset($data['skills']);
        }
        $request->merge($data);
        $request->validateResolved();
        return $request;
    }
    protected function handleResponse($response)
    {
        $content = $response->getData(true);
        
        if (isset($content['message'])) {
            $this->info($content['message']);
        }

        if (isset($content['jobOffer'])) {
            $this->line("Detalls de l'oferta:");
            foreach ($content['jobOffer'] as $key => $value) {
                $this->line("- {$key}: {$value}");
            }
        }
    }
    protected function handleValidationException(ValidationException $e)
    {
        foreach ($e->errors() as $field => $messages) {
            foreach ($messages as $message) {
                $this->error("Error en el camp {$field}: {$message}");
            }
        }
    }
}
