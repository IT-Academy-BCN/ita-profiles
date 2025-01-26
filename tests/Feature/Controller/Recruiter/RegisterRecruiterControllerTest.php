<?php

namespace Tests\Feature\Controller\Recruiter;

use App\Models\Recruiter;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterRecruiterControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $role;
    private $company;
    private $recruiterWithCompany;
    private $recruiterWithoutCompany;

    protected function setUp(): void
    {
        parent::setUp();

        $this->role = Role::firstOrCreate(
            ['name' => 'recruiter', 'guard_name' => 'api']
        );

        $this->company = Company::factory()->create();

        $this->recruiterWithCompany = Recruiter::factory()->create([
            'company_id' => $this->company->id,
            'role_id' => $this->role->id,
        ]);

        $this->recruiterWithoutCompany = Recruiter::factory()->create([
            'role_id' => $this->role->id,
            'company_id' => null,
        ]);   
    }

    public function testRoleExists(): void
    {
        $this->assertNotNull($this->role);
        $this->assertEquals('recruiter', $this->role->name);
    }

    public function testUserCreationWithCompany(): void
    {
        $response = $this->postJson('/api/v1/recruiter/register', [
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'dni' => '65362114R',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => $this->role->id,
            'company_id' => $this->company->id,
            'terms' => true,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('recruiters', [
            'user_id' => $response->json('recruiter.user_id'),
            'company_id' => $this->company->id,
            'role_id' => $this->role->id
        ]);
    }

    public function testRecruiterCreationWithoutCompany(): void
    {
        $response = $this->postJson('/api/v1/recruiter/register', [
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'dni' => '65362114R',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => $this->role->id,
            'company_id' => null,
            'terms' => true,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('recruiters', [
            'user_id' => $response->json('recruiter.user_id'),
            'company_id' => null,
            'role_id' => $this->role->id
        ]);
    }

    public function testRecruiterAlreadyExists(): void
    {
        $user = User::create([
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'dni' => '65362114R',
            'password' => bcrypt('password'),
        ]);
        
    
        $recruiter = Recruiter::create([
            'user_id' => $user->id,
            'company_id' => $this->company->id,
            'role_id' => $this->role->id,
        ]);

        $response = $this->postJson('/api/v1/recruiter/register', [
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'dni' => '65362114R',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => $this->role->id,
            'company_id' => $this->company->id,
            'terms' => true,
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseHas('users', [
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'dni' => '65362114R',
        ]);

        $this->assertDatabaseMissing('recruiters', [
            'user_id' => $response->json('recruiter.user_id'),
            'company_id' => $this->company->id,
            'role_id' => $this->role->id
        ]);
    }
}
