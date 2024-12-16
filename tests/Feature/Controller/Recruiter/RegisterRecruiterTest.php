<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Recruiter;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\Company;
use App\Models\User;

class RegisterRecruiterTest extends TestCase
{
    use DatabaseTransactions;
    private $company;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create();

        $this->user = User::factory()->create();
    }

    public function testRecruiterCanRegisterSuccessfully()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => 'dMl0X@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => $this->company->id,
            'terms' => 'true',
        ];
        
        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'email' => $data['email'],
            'dni' => $data['dni'],
        ]);

        $this->assertDatabaseHas('recruiters', [
            'company_id' => $data['company_id'],
        ]);
    }

    public function testRecruiterCanRegisterSuccessfullyWithNullCompany()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => 'dMl0X@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => null,
            'terms' => 'true',
        ];
        
        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(201);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithoutAcceptingTerms()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => 'dMl0X@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => $this->company->id,
            'terms' => 'false',
        ];
        
        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithInvalidDni()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '123456789A',
            'email' => 'dMl0X@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => $this->company->id,
            'terms' => 'true',
        ];

        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithDuplicateDni()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => $this->user->dni,
            'email' => 'dMl0X@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => $this->company->id,
            'terms' => 'true',
        ];

        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithDuplicateEmail()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => $this->user->email,
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => $this->company->id,
            'terms' => 'true',
        ];

        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithInvalidEmail()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => 'invalid-email',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => $this->company->id,
            'terms' => 'true',
        ];

        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithInvalidPassword()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => 'dMl0X@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'company_id' => $this->company->id,
            'terms' => 'true',
        ];

        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithInvalidPasswordConfirmation()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => 'dMl0X@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'password',
            'company_id' => $this->company->id,
            'terms' => 'true',
        ];

        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

    public function testRecruiterCannotRegisterSuccessfullyWithInvalidCompanyId()
    {
        $data = [
            'username' => 'testRecruiter',
            'dni' => '31574008E',
            'email' => 'dMl0X@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'company_id' => 'invalid-company-id',
            'terms' => 'true',
        ];

        $response = $this->postJson(route('recruiter.register'),$data);

        $response->assertStatus(422);
    }

}

