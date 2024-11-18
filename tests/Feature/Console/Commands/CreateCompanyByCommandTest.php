<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\app\Http\Controllers\api\Company\CreateCompanyController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;
use Tests\TestCase;


class CreateCompanyByCommandTest extends TestCase
{
   use DatabaseTransactions;

   public function testCompanyModelExists() : void
   {
       $this->assertTrue(class_exists(Company::class), "The Company model does not exist.");
   }

   public function testCanInstantiateController(): void
   {
       $companyController = new CreateCompanyController();

       $this->assertInstanceOf(CreateCompanyController::class, $companyController);
   }

   public function testCompanyCanBeCreatedViaCommand(): void
   {
       $this->artisan('create:company')
           ->expectsQuestion('Nombre de la compañia:', 'Test Company')
           ->expectsQuestion('Email:', 'test@test.es')
           ->expectsQuestion('CIF:', 'B12345678')
           ->expectsQuestion('Localizacion:', 'Test Location')
           ->expectsQuestion('Pagina web:', 'https://test.com')
           ->assertExitCode(0);

       $this->assertDatabaseHas('companies', [
           'name' => 'Test Company',
           'email' => 'test@localhost',
           'CIF' => 'B12345678',
           'location' => 'Test Location',
           'website' => 'https://test.com/',
       ]);
   }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testCanShowErrorMessageWithInvalidData(array $invalidData, array $expectedErrors): void
    {
        $this->artisan('create:company')
            ->expectsQuestion('Dime el nombre de la compañia:', $invalidData['name'])
            ->expectsQuestion('Dime el email:', $invalidData['email'])
            ->expectsQuestion('Dime el CIF:', $invalidData['CIF'])
            ->expectsQuestion('Dime la location:', $invalidData['location'])
            ->expectsQuestion('Dime el sitio web:', $invalidData['website'])
            ->assertExitCode(1);

            foreach ($expectedErrors as $field) {
                $this->assertStringContainsString(
                    "El campo {$field} es inválido.",
                    $this->output()
                );
            }
    }

    public static function invalidDataProvider(): array
    {
        return [
            // cases for name
            'invalid name: numeric' => [
                [
                    'name' => '12345',
                    'email' => 'validEmail@test.com',
                    'CIF' => 'B12345678',
                    'location' => 'validLocation',
                    'website' => 'https://valid-url.com',
                ],
                ['name']
            ],
            'invalid name: too short' => [
                [
                    'name' => 'A',
                    'email' => 'validEmail@test.com',
                    'CIF' => 'B12345678',
                    'location' => 'validLocation',
                    'website' => 'https://valid-url.com',
                ],
                ['name']
            ],
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
            'invalid name: special characters' => [
                [
                    'name' => '!@#$%^&*',
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
            'invalid location - contains special characters' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => 'Invalid!@#',
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
            'invalid website - empty' => [
                [
                    'name' => 'Valid Name',
                    'email' => 'valid@example.com',
                    'CIF' => 'B12345678',
                    'location' => 'Valid Location',
                    'website' => '',
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
    }

}
