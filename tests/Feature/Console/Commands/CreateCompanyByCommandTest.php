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
            ->expectsQuestion('Company name (ex: It Academy)', 'Test Company')
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'test@company.com')
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', 'B12345678')
            ->expectsQuestion('Location (ex: Barcelona)', 'Test Location')
            ->expectsQuestion('Website (ex: https://itacademy.barcelonactiva.cat/)', 'https://www.testcompany.com')
            ->expectsConfirmation('Save this data?', 'yes')
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
            ->expectsQuestion('Company name (ex: It Academy)', '')
            ->expectsOutput('Company name is required.')
            ->expectsQuestion('Company name (ex: It Academy)', 'Valid Company')
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'invalid-email')
            ->expectsOutput('Enter a valid email address.')
            ->expectsQuestion('Email (ex: itacademy@example.com)', 'valid@test.com')
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', '123')
            ->expectsOutput('Enter a valid CIF.')
            ->expectsQuestion('CIF (ex: A12345678 / 12345678A / A1234567B)', 'B12345678')
            ->expectsQuestion('Location (ex: Barcelona)', 'A')
            ->expectsOutput('Location must have at least 3 characters.')
            ->expectsQuestion('Location (ex: Barcelona)', 'Valid Location')
            ->expectsQuestion('Website (ex: https://itacademy.barcelonactiva.cat/)', 'invalid-url')
            ->expectsOutput('Enter a valid website.')
            ->expectsQuestion('Website (ex: https://itacademy.barcelonactiva.cat/)', 'https://valid.com')
            ->expectsConfirmation('Save this data?', 'yes')
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
