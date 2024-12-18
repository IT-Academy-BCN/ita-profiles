<?php
declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateCompanyByCommandTest extends TestCase
{
    use DatabaseTransactions;

    public function testCompanyCanBeCreatedViaCommand(): void
    {
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía', 'Test Company')
            ->expectsQuestion('Email', 'test@company.com')
            ->expectsQuestion('CIF', 'B12345678')
            ->expectsQuestion('Localización', 'Test Location')
            ->expectsQuestion('Página web', 'https://www.testcompany.com')
            ->expectsConfirmation('¿Desea proceder con estos datos?', 'yes')
            ->expectsOutput('Company Test Company was created successfully.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'CIF' => 'B12345678',
            'location' => 'Test Location',
            'website' => 'https://www.testcompany.com',
        ]);
    }

    public function testCommandHandlesInvalidData(): void
    {
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía', '')
            ->expectsOutput('El nombre de la compañía es obligatorio.')
            ->expectsQuestion('Nombre de la compañía', 'Valid Company')
            ->expectsQuestion('Email', 'invalid-email')
            ->expectsOutput('Introduce un correo electrónico válido.')
            ->expectsQuestion('Email', 'valid@test.com')
            ->expectsQuestion('CIF', '123')
            ->expectsOutput('El formato de CIF no es válido.')
            ->expectsQuestion('CIF', 'B12345678')
            ->expectsQuestion('Localización', 'A')
            ->expectsOutput('La localización debe tener al menos 3 caracteres.')
            ->expectsQuestion('Localización', 'Valid Location')
            ->expectsQuestion('Página web', 'invalid-url')
            ->expectsOutput('La página web debe contener una URL válida.')
            ->expectsQuestion('Página web', 'https://valid.com')
            ->expectsConfirmation('¿Desea proceder con estos datos?', 'yes')
            ->expectsOutput('Company Valid Company was created successfully.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('companies', [
            'name' => 'Valid Company',
            'email' => 'valid@test.com',
            'CIF' => 'B12345678',
            'location' => 'Valid Location',
            'website' => 'https://valid.com',
        ]);
    }
}
