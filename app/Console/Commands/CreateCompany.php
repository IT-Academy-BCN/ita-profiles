<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
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

    /**
     * The CreateCompanyController instance.
     *
     * @var CreateCompanyController
     */
    protected $createCompanyController;

    /**
     * The constructor injects the CreateCompanyController dependency.
     *
     * @param CreateCompanyController $createCompanyController
     */
    public function __construct(CreateCompanyController $createCompanyController)
    {
        parent::__construct();
        $this->createCompanyController = $createCompanyController;
    }

    protected function configure()
    {
        $this->setName('create:company')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the company')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email address of the company')
            ->addArgument('CIF', InputArgument::OPTIONAL, 'The unique CIF of the company')
            ->addArgument('location', InputArgument::OPTIONAL, 'The physical location of the company')
            ->addArgument('website', InputArgument::OPTIONAL, 'The company\'s website URL -OPTIONAL-');
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->askCompanyData();

        $this->info("Resumen de la empresa:");
        foreach ($data as $key => $value) {
            $this->line(" - {$key}: {$value}");
        }

        if (!$this->confirm('¿Desea proceder con estos datos?', true)) {
            $this->info('Operación cancelada.');
            return 1;
        }
        $request = $this->createRequest($data);
        $response = $this->createCompanyController->__invoke($request);

        $this->handleResponse($response);
        return 0;
    }

    /**
     * Get company data from user input.
     *
     * @return array
     */
    protected function askCompanyData(): array
    {
        $rules = (new StoreCompanyRequest())->rules();
        return [
            'name' => $this->askValid('Nombre de la compañía (ex: It Academy)', 'name', $rules),
            'email' => $this->askValid('Email (ex: itacademy@example.com)', 'email', $rules),
            'CIF' => $this->askValid('CIF (ex: A12345678 / 12345678A / A1234567B)', 'CIF', $rules),
            'location' => $this->askValid('Localización (ex: Barcelona)', 'location', $rules),
            'website' => $this->askValid('Página web (ex: https://itacademy.barcelonactiva.cat/)', 'website', $rules),
        ];
    }

    /**
     * Prompt the user for input and validate it using StoreCompanyRequest.
     *
     * @param string $question
     * @param string $field
     * @param array $rules
     * @return string
     */
    protected function askValid(string $question, string $field, array $rules): string|null
    {
        do {
            $value = $this->ask($question);

            $validator = Validator::make(
                [$field => $value],
                [$field => $rules[$field]]
            );

            if ($validator->fails()) {
                $this->error($validator->errors()->first($field));
            } else {
                return $value;
            }
        } while (true);
    }

    /**
     * Create a StoreCompanyRequest and merge the data.
     *
     * @param array $data
     * @return StoreCompanyRequest
     */
    protected function createRequest(array $data): StoreCompanyRequest
    {
        $request = new StoreCompanyRequest();
        $request->merge($data);
        return $request;
    }

    /**
     * Handle the response from the controller.
     *
     * @param \Illuminate\Http\JsonResponse $response
     */
    protected function handleResponse($response)
    {
        $content = $response->getData(true);
        if (isset($content['message'])) {
            $this->info($content['message']);
        }
    }
}
