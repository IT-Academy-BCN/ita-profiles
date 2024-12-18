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
        $this->info("Job offer preview:");
        foreach ($data as $key => $value) {
            $this->line("- {$key}: {$value}");
        }
        if (!$this->confirm('Do you want to proceed with this data?', true)) {
            $this->info('Operation cancelled.');
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
            $recruiterInput = $this->argument('recruiter_id') ?? $this->ask('Enter the recruiter ID.');

            try {
                $recruiter = Recruiter::findOrFail($recruiterInput);

                if (!$recruiter->company_id) {
                    $this->error('The recruiter does not have an assigned company.');
                    $attempts++;

                    if ($attempts >= $maxAttempts) {
                        $this->error('You have exceeded the maximum number of attempts. Please restart the process.');
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
                $this->error("Recruiter with ID {$recruiterInput} not found.");
                $attempts++;

                if ($attempts >= $maxAttempts) {
                    $this->error('You have exceeded the maximum number of attempts. Please restart the process.');
                    exit(1);
                }
            }
        } while (true);

        $fields = [
            'title' => 'Enter the job offer title (e.g., Senior Frontend Developer)',
            'description' => 'Enter the job offer description (e.g., Seeking a creative developer.)',
            'location' => 'Enter the job offer location (e.g., Barcelona)',
            'salary' => 'Enter the job offer salary (optional, e.g., 25000 - 35000)',
        ];

        foreach ($fields as $field => $prompt) {
            $attempts = 0;
            do {
                $value = $this->argument($field) ?? $this->ask($prompt . "\n(or type 'cancel' to exit)");

                if ($value !== null && strtolower($value) === 'cancel') {
                    $this->info('Operation cancelled.');
                    exit(0);
                }

                $rules = (new CreateJobOfferRequest(app(), app('redirect')))->rules();

                $validator = Validator::make(
                    [$field => $value],
                    [$field => $rules[$field]]
                );

                if ($validator->fails()) {
                    $this->error("Error in {$field}: " . $validator->errors()->first($field));
                    $attempts++;
                    if ($attempts >= $maxAttempts) {
                        $this->error('You have exceeded the maximum number of attempts. Please restart the process.');
                        exit(1);
                    }
                } else {
                    $data[$field] = $value;
                    break;
                }
            } while (true);
        }

        $skills = $this->argument('skills') ?? $this->ask('Enter the required skills (optional, separated by commas or "cancel")');

        if ($skills !== null && strtolower($skills) === 'cancel') {
            $this->info('Operation cancelled.');
            exit(0);
        }

        if ($skills !== null && trim($skills) !== '') {
            $validator = Validator::make(
                ['skills' => $skills],
                ['skills' => (new CreateJobOfferRequest(app(), app('redirect')))->rules()['skills']]
            );

            if ($validator->fails()) {
                $this->error("Error in skills: " . $validator->errors()->first('skills'));
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
            $this->line("Offer details:");
            foreach ($content['jobOffer'] as $key => $value) {
                $this->line("- {$key}: {$value}");
            }
        }
    }
    protected function handleValidationException(ValidationException $e)
    {
        foreach ($e->errors() as $field => $messages) {
            foreach ($messages as $message) {
                $this->error("Error in the field {$field}: {$message}");
            }
        }
    }
}
