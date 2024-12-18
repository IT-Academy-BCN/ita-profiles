<?php
declare(strict_types=1);
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCompanyRequest;

class CreateCompany extends Command
{
    protected $signature = 'create:company';
    protected $description = 'Create a new company via console interactively.';

    public function handle(): int
    {
        $data = $this->collectData();

        if (!$this->confirm('¿Desea proceder con estos datos?', true)) {
            $this->info('Operación cancelada.');
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
            'name' => 'Nombre de la compañía',
            'email' => 'Email',
            'CIF' => 'CIF',
            'location' => 'Localización',
            'website' => 'Página web'
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
