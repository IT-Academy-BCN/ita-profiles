<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use Illuminate\Console\Command;
use App\Http\Requests\StoreCompanyRequest;

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
        $name = $this->ask('Nombre de la compañia:');
        $email = $this->ask('Email:');
        $CIF = $this->ask('CIF:');
        $location = $this->ask('Localizacion:');
        $website = $this->ask('Pagina web:');

        $data = compact('name', 'email', 'CIF', 'location', 'website');

        $request = new StoreCompanyRequest();
        $request->replace($data);

        $createCompanyController = new CreateCompanyController();
        $response = $createCompanyController($request);

        $content = $response->getData(true);

        if (isset($content['message']))
        {
            $this->info($content['message']);
        }

    }
}
