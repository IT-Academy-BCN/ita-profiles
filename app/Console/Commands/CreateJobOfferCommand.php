<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Recruiter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Job\CreateJobOfferRequest;
use Symfony\Component\Console\Input\InputArgument;
use App\Http\Controllers\api\Job\JobOfferController;

class CreateJobOfferCommand extends Command
{

    protected $description = 'Create a new job offer in the database giving the required arguments step by step in terminal.' . PHP_EOL . '  Example:
    Recruiter ID: Provide the unique recruiter identifiere
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
        $this->setName('create:job-offer')
            ->addArgument('recruiter_id', InputArgument::OPTIONAL, 'The ID of the recruiter')
            ->addArgument('title', InputArgument::OPTIONAL, 'The title of the job offer')
            ->addArgument('description', InputArgument::OPTIONAL, 'The description of the job offer')
            ->addArgument('location', InputArgument::OPTIONAL, 'The location of the job offer')
            ->addArgument('salary', InputArgument::OPTIONAL, 'The salary for the job offer')
            ->addArgument('skills', InputArgument::OPTIONAL, 'The skills required for the job offer (Optional)');
    }

    public function handle()
    {
        $data = $this->collectValidatedJobOfferData();
        $this->info("Vista prèvia de l'oferta de treball:");
        foreach ($data as $key => $value) {
            $this->line("- {$key}: {$value}");
        }
        if (!$this->confirm('Vols procedir amb aquestes dades?', true)) {
            $this->info('Operació cancel·lada.');
            return 1;
        }
        try {

            $request = $this->createRequest($data);
            $response = $this->jobOfferController->createJobOffer($request);
            $this->handleResponse($response);
            return 0;
        } catch (ValidationException $e) {
            $this->handleValidationException($e);
            return 1;
        }
    }

    protected function collectValidatedJobOfferData(): array
    {
        $data = [];
        $maxAttempts = 3;
        $attempts = 0;

        do {
            $recruiterInput = $this->argument('recruiter_id') ?? $this->ask('Introdueix l\'ID del reclutador');

            try {
                $recruiter = Recruiter::findOrFail($recruiterInput);

                if (!$recruiter->company_id) {
                    $this->error('El reclutador no té una empresa assignada.');
                    $attempts++;

                    if ($attempts >= $maxAttempts) {
                        $this->error('Has superat el nombre màxim d\'intents. Reinicia el procés.');
                        exit(1);
                    }
                    continue;
                }

                $data = [
                    'recruiter_id' => $recruiter->id,
                    'company_id' => $recruiter->company_id,
                ];

                break;
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->error("Reclutador amb ID {$recruiterInput} no trobat.");
                $attempts++;

                if ($attempts >= $maxAttempts) {
                    $this->error('Has superat el nombre màxim d\'intents. Reinicia el procés.');
                    exit(1);
                }
            }
        } while (true);

        $fields = [
            //'recruiter_id' => 'Introdueix l\'ID del reclutador',
            'title' => 'Introdueix el títol de l\'oferta de feina (ex: Senior Frontend Developer)',
            'description' => 'Introdueix la descripció de l\'oferta de feina (ex: Seeking a creative developer.)',
            'location' => 'Introdueix la ubicació de l\'oferta de feina (ex: Barcelona)',
            'salary' => 'Introdueix el sou de l\'oferta de feina (opcional ex: 25000 - 35000)',
        ];

        foreach ($fields as $field => $prompt) {
            $attempts = 0;
            do {
                $value = $this->argument($field) ?? $this->ask($prompt . "\n(o escriu 'cancel' per sortir)");

                if ($value !== null && strtolower($value) === 'cancel') {
                    $this->info('Operació cancel·lada.');
                    exit(0);
                }

                $rules = (new CreateJobOfferRequest(app(), app('redirect')))->rules();

                $validator = Validator::make(
                    [$field => $value],
                    [$field => $rules[$field]]
                );
                /*
                if ($field === 'recruiter_id') {
                    $validator = Validator::make(
                        [$field => $value],
                        [$field => 'required|exists:recruiters,id']
                    );
                } else {
                    $validator = Validator::make(
                        [$field => $value],
                        [$field => $rules[$field]]
                    );
                }*/

                if ($validator->fails()) {
                    $this->error("Error en {$field}: " . $validator->errors()->first($field));
                    $attempts++;
                    if ($attempts >= $maxAttempts) {
                        $this->error('Has superat el nombre màxim d\'intents. Reinicia el procés.');
                        exit(1);
                    }
                } else {
                    $data[$field] = $value;
                    break;
                }
            } while (true);
        }

        $skills = $this->argument('skills') ?? $this->ask('Introdueix les habilitats requerides (opcional, separades per comes o "cancel")');

        if ($skills !== null && strtolower($skills) === 'cancel') {
            $this->info('Operació cancel·lada.');
            exit(0);
        }

        if ($skills !== null && trim($skills) !== '') {
            $validator = Validator::make(
                ['skills' => $skills],
                ['skills' => (new CreateJobOfferRequest(app(), app('redirect')))->rules()['skills']]
            );

            if ($validator->fails()) {
                $this->error("Error en habilitats: " . $validator->errors()->first('skills'));
                $data['skills'] = null;
            } else {
                $data['skills'] = $skills;
            }
        } else {
            $data['skills'] = null;
        }

        return $data;
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
