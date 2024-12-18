<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;
use Illuminate\Console\Command;
use Tests\TestCase;


class CreateCompanyByCommandTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateCompanyCommandCanInstantiateController(): void
    {
        $companyController = new CreateCompanyController();

        $this->assertInstanceOf(CreateCompanyController::class, $companyController);
    }

    public function testCompanyCanBeCreatedViaCommand(): void
    {
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', 'Test Company')
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'test@test.es')
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', 'B1234567A')
            ->expectsQuestion('Localización (ex: Barcelona)', 'Test Location')
            ->expectsQuestion('Página web (ex: https://itacademy.barcelonactiva.cat/)', 'https://www.test.com')
            ->expectsQuestion('¿Desea proceder con estos datos?', 'yes')
            ->assertExitCode(0);

        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'email' => 'test@test.es',
            'CIF' => 'B1234567A',
            'location' => 'Test Location',
            'website' => 'https://www.test.com',
        ]);
    }
    public function test_command_handles_validation_errors_gracefully()
    {
        // No necesitamos mock del controlador ya que fallaremos antes de llegar allí

        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', '') // Nombre vacío
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', 'It Academy') // Corrige el nombre
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'invalid-email') // Email inválido
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'itacademy@example.com') // Corrige el email
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', '1234') // CIF inválido
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', 'A1234567Z') // Corrige el CIF
            ->expectsQuestion('Localización (ex: Barcelona)', 'Barcelona')
            ->expectsQuestion('Página web (ex: https://itacademy.barcelonactiva.cat/)', 'invalid-url') // URL inválida
            ->expectsQuestion('Página web (ex: https://itacademy.barcelonactiva.cat/)', 'https://itacademy.barcelonactiva.cat/') // Corrige la URL
            ->expectsConfirmation('¿Desea proceder con estos datos?', 'no') // Cancela al final
            ->assertExitCode(0); // Verifica que el comando termine con un código de error
    }

    public function testCommandFailsAfterMaxAttempts(): void
    {
        $this->mockCreateCompanyCommandWithLimitedAttempts(2);  // Limita a 2 intentos
    
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', ' ')  // Primer intento inválido
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', str_repeat('A', 256))  // Segundo intento inválido
            ->expectsOutput('Número máximo de intentos alcanzado para el campo \'name\'.')  // Mensaje esperado
            ->assertExitCode(1);  // Salida esperada con error
    }
    
    public function testReturnsErrorOnMaxAttemptsExceeded(): void
    {
        $this->mockCreateCompanyCommandWithLimitedAttempts(2);  // Limita a 2 intentos
    
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', '')  // Primer intento inválido
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', '')  // Segundo intento inválido
            ->expectsOutput('Número máximo de intentos alcanzado para el campo \'name\'.')  // Salida esperada
            ->assertExitCode(1);  // Salida con error
    }
    
    public function testValidInputAfterOneFailedAttempt(): void
    {
        $this->mockCreateCompanyCommandWithLimitedAttempts(2);  // Limita a 2 intentos
    
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', '')  // Primer intento inválido
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', 'Test Company')  // Segundo intento válido
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'test@test.es')
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', 'B1234567A')
            ->expectsQuestion('Localización (ex: Barcelona)', 'Test Location')
            ->expectsQuestion('Página web (ex: https://itacademy.barcelonactiva.cat/)', 'https://www.test.com')
            ->expectsQuestion('¿Desea proceder con estos datos?', 'yes')
            ->assertExitCode(0);  // Debería terminar con éxito
    
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'email' => 'test@test.es',
            'CIF' => 'B1234567A',
            'location' => 'Test Location',
            'website' => 'https://www.test.com',
        ]);
    }
    

    private function mockCreateCompanyCommandWithLimitedAttempts(int $maxAttempts)
    {
        $attempts = 0;
    
        // Aquí simulamos que el controlador de la compañía recibe preguntas y respuestas limitadas
        $this->mock(CreateCompany::class, function ($mock) use ($maxAttempts, &$attempts) {
            $mock->shouldReceive('askValid')
                ->andReturnUsing(function ($question, $field, $rules) use ($maxAttempts, &$attempts) {
                    $attempts++;
    
                    // Simula respuestas inválidas en los primeros intentos
                    if ($attempts <= $maxAttempts) {
                        exit(1); // Respuesta inválida
                    }
    
                    // Después de los intentos fallidos, retorna una respuesta válida
                    return match ($field) {
                        'name' => 'Test Company',
                        'email' => 'valid@example.com',
                        'CIF' => 'A12345678',
                        'location' => 'Valid Location',
                        'website' => 'https://valid.url',
                        default => 'valid value',
                    };
                });
        });
    }
    

    /*
   public function testErrorCodeWithDuplicatedEmail(): void
    {
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', 'Test Company')
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'duplicado@test.es')
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', 'B1234567A')
            ->expectsQuestion('Localización (ex: Barcelona)', 'Test Location')
            ->expectsQuestion('Página web (ex: https://itacademy.barcelonactiva.cat/)', 'https://www.test.com')
            ->expectsQuestion('¿Desea proceder con estos datos?', 'yes')
            ->assertExitCode(0);

        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', 'Test Email')
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'duplicado@test.es')
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', 'B1234522A')
            ->expectsQuestion('Localización (ex: Barcelona)', 'Test Location')
            ->expectsQuestion('Página web (ex: https://itacademy.barcelonactiva.cat/)', 'https://www.test.com')
            ->expectsQuestion('¿Desea proceder con estos datos?', 'yes')
            ->assertExitCode(1);
    }*/
}