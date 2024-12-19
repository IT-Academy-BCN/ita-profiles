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
           ->expectsQuestion('Company name:', 'Test Company')
           ->expectsQuestion('Email:', 'test@test.es')
           ->expectsQuestion('CIF:', 'B1234567A')
           ->expectsQuestion('Location:', 'Test Location')
           ->expectsQuestion('Website:', 'https://www.test.com')
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
    public function testReturnsErrorCodeOnInvalidData(array $invalidData): void
    {
        $this->artisan('create:company')
            ->expectsQuestion('Company name:', $invalidData['name'])
            ->expectsQuestion('Email:', $invalidData['email'])
            ->expectsQuestion('CIF:', $invalidData['CIF'])
            ->expectsQuestion('Location:', $invalidData['location'])
            ->expectsQuestion('Website:', $invalidData['website'])
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
    }

    public function testErrorCodeWithDuplicatedEmail(): void
   {
       $this->artisan('create:company')
           ->expectsQuestion('Company name:', 'Test Company')
           ->expectsQuestion('Email:', 'duplicado@test.es')
           ->expectsQuestion('CIF:', 'B1234567A')
           ->expectsQuestion('Location:', 'Test Location')
           ->expectsQuestion('Website:', 'https://www.test.com')
           ->assertExitCode(0);

           $this->artisan('create:company')
           ->expectsQuestion('Company name:', 'Test Email')
           ->expectsQuestion('Email:', 'duplicado@test.es')
           ->expectsQuestion('CIF:', 'B1234522A')
           ->expectsQuestion('Location:', 'Test Location')
           ->expectsQuestion('Website:', 'https://www.test.com')
           ->assertExitCode(1);
   }

}
