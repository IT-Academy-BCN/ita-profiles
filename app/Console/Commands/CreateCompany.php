<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use Illuminate\Console\Command;

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
        $createCompanyController = new CreateCompanyController();
        $name = $this->ask('Dime el nombre de la compañia:');
        $email = $this->ask('Dime el email:');
        $CIF = $this->ask('Dime el CIF:');
        $location = $this->ask('Dime la location:');
        $website = $this->ask('Dime el sitio web:');

        $data = compact('name', 'email', 'CIF', 'location', 'website');

        $response = $createCompanyController->__invoke($data);

        $content = $response->getData(true);

        if (isset($content['message']))
        {
            $this->info($content['message']);
        }

    }
}
