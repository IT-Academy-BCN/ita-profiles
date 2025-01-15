<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCompanyRequest;
use Symfony\Component\Console\Input\InputArgument;

class CreateCompany extends Command
{
    protected $description = (
        'Create a new company in the database giving the required arguments step by step in terminal.' . PHP_EOL . '  Example:
        name: It Academy
        email: itacademy@test.es
        CIF: A1234567Z
        location: Barcelona
        website: https://itacademy.barcelonactiva.cat/'
    );

    protected function configure()
    {
        $this->setName('create:company')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the company')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email address of the company')
            ->addArgument('CIF', InputArgument::OPTIONAL, 'The unique CIF of the company')
            ->addArgument('location', InputArgument::OPTIONAL, 'The physical location of the company')
            ->addArgument('website', InputArgument::OPTIONAL, 'The company\'s website URL -OPTIONAL-');
    }
    
    public function handle(): int
    {
        $data = $this->collectData();

        if (!$this->confirm('Save this data?', true)) {
            $this->info('Cancelled.');
            return 0;
        }
        $company = Company::create($data);
        $this->info("Company {$company->name} was created successfully.");
        return 0;
    }

    protected function collectData(): array
    {
        $request = new StoreCompanyRequest();
        $data = [];

        $fields = [
            'name' => 'Company name (ex: It Academy)',
            'email' => 'Email (ex: itacademy@example.com)',
            'CIF' => 'CIF (ex: A12345678 / 12345678A / A1234567B)',
            'location' => 'Location (ex: Barcelona)',
            'website' => 'Website (ex: https://itacademy.barcelonactiva.cat/)'
        ];

        foreach ($fields as $field => $question) {
            $data[$field] = $this->askValidated($question, $field, $request);
        }

        return $data;
    }

    protected function askValidated(string $question, string $field, StoreCompanyRequest $request): ?string
    {
        $rules = $request->rules();
        $messages = $request->messages();

        do {
            $value = $this->ask($question);

            if ($field === 'website' && empty($value)) {
                return null;
            }

            $validator = Validator::make(
                [$field => $value],
                [$field => $rules[$field]],
                $messages
            );

            if ($validator->fails()) {
                $this->error($validator->errors()->first($field));
                continue;
            }

            return $value;
        } while (true);
    }
}
