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

    protected function setUp(): void
    {
        parent::setUp();

        $this->role = Role::firstOrCreate(
            ['name' => 'recruiter', 'guard_name' => 'api']
        );

        $this->company = Company::factory()->create();
  
    }

    public function testRoleExists(): void
    {
        $this->assertNotNull($this->role);
        $this->assertEquals('recruiter', $this->role->name);
    }

    public function testUserCreationWithCompany(): void
    {
        $response = $this->postJson('/api/v1/recruiter/register', [
            'username' => 'john_doe2',
            'email' => 'john.doe2@example.com',
            'dni' => '31360812J',
            'password' => 'Password%123',
            'password_confirmation' => 'Password%123',
            'company_id' => $this->company->id,
            'terms' => true,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'username' => 'john_doe2',
            'email' => 'john.doe2@example.com',
            'dni' => '31360812J',
        ]);

        $this->assertDatabaseHas('recruiters', [
            'user_id' => $response->json('recruiter.user_id'),
            'company_id' => $this->company->id,
            'role_id' => $this->role->id,
        ]);
    }


    public function testRecruiterCreationWithoutCompany(): void
    {
        $response = $this->postJson('/api/v1/recruiter/register', [
            'username' => 'jane_doe',
            'email' => 'jane.doe@example.com',
            'dni' => '64401581V',
            'password' => 'Password%123',
            'password_confirmation' => 'Password%123',
            'company_id' => null,
            'terms' => true,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'username' => 'jane_doe',
            'email' => 'jane.doe@example.com',
            'dni' => '64401581V',
        ]);

        $this->assertDatabaseHas('recruiters', [
            'user_id' => $response->json('recruiter.user_id'),
            'company_id' => null,
            'role_id' => $this->role->id,
        ]);
    }

    public function testRecruiterAlreadyExists(): void
    {
        $user = User::create([
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'dni' => '65362114R',
            'password' => bcrypt('Password%123'),
        ]);

        Recruiter::create([
            'user_id' => $user->id,
            'company_id' => $this->company->id,
            'role_id' => $this->role->id,
        ]);

        $response = $this->postJson('/api/v1/recruiter/register', [
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'dni' => '65362114R',
            'password' => 'Password%123',
            'password_confirmation' => 'Password%123',
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
            'role_id' => $this->role->id,
        ]);
    }

    public function testTermsNotAccepted(): void
    {
        $response = $this->postJson('/api/v1/recruiter/register', [
            'username' => 'jane_doe',
            'email' => 'jane.doe@example.com',
            'dni' => '65362114Z',
            'password' => 'Password%123',
            'password_confirmation' => 'Password%123',
            'company_id' => null,
            'terms' => false,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['terms']);
    }
}