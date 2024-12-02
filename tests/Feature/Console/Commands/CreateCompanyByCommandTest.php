<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use App\Http\Controllers\api\Company\CreateCompanyController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;
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

    /**
     * @dataProvider invalidDataProvider
     */
    /*public function testReturnsErrorCodeOnInvalidData(array $invalidData): void
    {
        $this->artisan('create:company')
            ->expectsQuestion('Nombre de la compañía (ex: It Academy)', $invalidData['name'])
            ->expectsQuestion('Email (ex: itacademy@example.com)', $invalidData['email'])
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', $invalidData['CIF'])
            ->expectsQuestion('Localización (ex: Barcelona)', $invalidData['location'])
            ->expectsQuestion('Página web (ex: https://itacademy.barcelonactiva.cat/)', $invalidData['website'])
            ->expectsQuestion('¿Desea proceder con estos datos?', 'yes')
            ->assertExitCode(1);
    }

    public static function invalidDataProvider(): array
    {
        return [
            // cases for name
            'invalid name: too long' => [
                [
                    'name' => str_repeat('A', 256),
                    'email' => 'validEmail@test.com',
                    'CIF' => 'B12345678',
                    'location' => 'validLocation',
                    'website' => 'https://valid-url.com',
                ],
                ['name']
            ],
            'invalid name: empty' => [
                [
                    'name' => '',
                    'email' => 'validEmail@test.com',
                    'CIF' => 'B12345678',
                    'location' => 'validLocation',
                    'website' => 'https://valid-url.com',
                ],
                ['name']
            ],

            // cases for email
            'invalid email: not an email' => [
                [
                    'name' => 'ValidName',
                    'email' => 'not-an-email',
                    'CIF' => 'B12345678',
                    'location' => 'validLocation',
                    'website' => 'https://valid-url.com',
                ],
                ['email']
            ],
            'invalid email: empty' => [
                [
                    'name' => 'ValidName',
                    'email' => '',
                    'CIF' => 'B12345678',
                    'location' => 'validLocation',
                    'website' => 'https://valid-url.com',
                ],
                ['email']
            ],

            // cases for CIF
            'invalid CIF - too short' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B1234',
                    'location' => 'Valid Location',
                    'website' => 'https://example.com',
                ],
                ['CIF']
            ],
            'invalid CIF - too long' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B1234567890',
                    'location' => 'Valid Location',
                    'website' => 'https://example.com',
                ],
                ['CIF']
            ],
            'invalid CIF - contains letters' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'INVALIDCIF',
                    'location' => 'Valid Location',
                    'website' => 'https://example.com',
                ],
                ['CIF']
            ],
            'invalid CIF - empty' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => '',
                    'location' => 'Valid Location',
                    'website' => 'https://example.com',
                ],
                ['CIF']
            ],
            'invalid CIF - null' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => null,
                    'location' => 'Valid Location',
                    'website' => 'https://example.com',
                ],
                ['CIF']
            ],

            // cases for Location
            'invalid location - too short' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => 'Lo',
                    'website' => 'https://example.com',
                ],
                ['location']
            ],
            'invalid location - too long' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => str_repeat('L', 256),
                    'website' => 'https://example.com',
                ],
                ['location']
            ],
            'invalid location - empty' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => '',
                    'website' => 'https://example.com',
                ],
                ['location']
            ],
            'invalid location - null' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => null,
                    'website' => 'https://example.com',
                ],
                ['location']
            ],

            // cases for website
            'invalid website - missing scheme' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => 'Valid Location',
                    'website' => 'example.com',
                ],
                ['website']
            ],
            'invalid website - invalid format' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => 'Valid Location',
                    'website' => 'not-a-url',
                ],
                ['website']
            ],
            'invalid website - too long' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => 'Valid Location',
                    'website' => str_repeat('https://example.com/', 100),
                ],
                ['website']
            ],
        ];
    }*/
    public function testReturnsErrorCodeOnInvalidData(array $invalidData, string $field): void
    {
        $command = $this->artisan('create:company');

        // Simula las preguntas y las respuestas en orden
        foreach ($invalidData as $key => $responses) {
            foreach ($responses as $response) {
                $command = $command->expectsQuestion($this->getQuestionText($key), $response);
            }
        }

        // Confirmación al final
        $command = $command->expectsQuestion('¿Desea proceder con estos datos?', 'yes');

        // Verificar que termina con código 1 (error)
        $command->assertExitCode(1);
    }

    /**
     * Provide invalid data sets for testing.
     *
     * @return array[]
     */
    public static function invalidDataProvider(): array
    {
        return [
            'invalid name: too long' => [
                [
                    'name' => [' ', str_repeat('A', 256)], // Respuesta inválida y luego válida
                ],
                'name',
            ],
            'invalid email: not an email' => [
                [
                    'email' => ['not-an-email', 'valid@example.com'], // Respuesta inválida y luego válida
                ],
                'email',
            ],
            'invalid CIF: wrong format' => [
                [
                    'CIF' => ['123', 'B12345678'], // Respuesta inválida y luego válida
                ],
                'CIF',
            ],
            'invalid website: not a URL' => [
                [
                    'website' => ['invalid-url', 'https://valid-url.com'], // Respuesta inválida y luego válida
                ],
                'website',
            ],
        ];
    }

    /**
     * Get the expected question text for a field.
     *
     * @param string $field
     * @return string
     */
    private function getQuestionText(string $field): string
    {
        $questions = [
            'name' => 'Nombre de la compañía (ex: It Academy)',
            'email' => 'Email (ex: itacademy@example.com)',
            'CIF' => 'CIF (ex: A12345678 / 12345678A / A1234567B)',
            'location' => 'Localización (ex: Barcelona)',
            'website' => 'Página web (ex: https://itacademy.barcelonactiva.cat/)',
        ];

        return $questions[$field];
    }

    
   /* public function testErrorCodeWithDuplicatedEmail(): void
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