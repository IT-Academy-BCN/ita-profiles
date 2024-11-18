<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
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
            $name = $this->ask('Dime el nombre de la compañia:');
            $email = $this->ask('Dime el email:');
            $CIF = $this->ask('Dime el CIF:');
            $location = $this->ask('Dime la location:');
            $website = $this->ask('Dime el sitio web:');

            $data = compact('name', 'email', 'CIF', 'location', 'website');

            // Validar manualmente
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'CIF' => ['required', 'string', 'size:9'],
                'location' => ['required', 'string', 'min:3', 'max:255'],
                'website' => ['required', 'url', 'max:255'],
            ]);

            $validator->validate(); // Lanza una excepción si hay errores

            // Llamar al controlador si la validación pasa
            $createCompanyController = new CreateCompanyController();
            $response = $createCompanyController->createCompanyController((object) $data);

            $content = $response->getData(true);

            if (isset($content['message'])) {
                $this->info($content['message']);
            }
        } catch (ValidationException $e) {
            // Mostrar errores de validación
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->error("Error en el campo {$field}: {$message}");
                }
            }

            return 1;
        }
    }
}
