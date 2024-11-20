<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Input\InputArgument;

class CreateCompany extends Command
{
    protected function configure()
    {
        $this->setName('create:company')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the company')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email address of the company')
            ->addArgument('CIF', InputArgument::OPTIONAL, 'The unique CIF of the company')
            ->addArgument('location', InputArgument::OPTIONAL, 'The physical location of the company')
            ->addArgument('website', InputArgument::OPTIONAL, 'The company\'s website URL -OPTIONAL-');
    }
    
    protected $description =('Create a new company in the database giving the required arguments step by step in terminal.'.PHP_EOL.'  Example:
        name: It Academy
        email: itacademy@test.es
        CIF: A1234567Z
        location: Barcelona
        website: https://itacademy.barcelonactiva.cat/');
             

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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $data = $this->getCompanyData();
            $request = $this->createRequest($data);

            $response = $this->createCompanyController->__invoke($request);

            $this->handleResponse($response);

            return 0;
        } catch (ValidationException $e) {
            $this->handleValidationException($e);
            return 1;
        }
    }

    /**
     * Get company data from user input.
     *
     * @return array
     */
    protected function getCompanyData(): array
    {
        return [
            'name' => $this->ask('Nombre de la compañia:'),
            'email' => $this->ask('Email:'),
            'CIF' => $this->ask('CIF:'),
            'location' => $this->ask('Localizacion:'),
            'website' => $this->ask('Pagina web:')
        ];
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
        $request->setContainer(app())
            ->setRedirector(app('redirect'))
            ->validateResolved();
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

    /**
     * Handle validation exceptions.
     *
     * @param ValidationException $e
     */
    protected function handleValidationException(ValidationException $e)
    {
        foreach ($e->errors() as $field => $messages) {
            foreach ($messages as $message) {
                $this->error("Error en el campo {$field}: {$message}");
            }
        }
    }    
}
