<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class CreateCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new company with name, email, CIF, location, and website';

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
