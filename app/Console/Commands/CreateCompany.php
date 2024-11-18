<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
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
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = $this->ask('Nombre de la compañia:');
            $email = $this->ask('Email:');
            $CIF = $this->ask('CIF:');
            $location = $this->ask('Localizacion:');
            $website = $this->ask('Pagina web:');

            $data = compact('name', 'email', 'CIF', 'location', 'website');

            $request = new StoreCompanyRequest();

            $request->setContainer(app(Container::class))->setRedirector(app('redirect'));

            $request->merge($data);

            $request->validateResolved();

            $createCompanyController = new CreateCompanyController();

            $response = $createCompanyController($request);

            $content = $response->getData(true);

            if (isset($content['message'])) {
                $this->info($content['message']);
            }
            return 0;
        } catch (ValidationException $e) {
            
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->error("Error en el campo {$field}: {$message}");
                }
            }

            return 1;
        }
    }
}
