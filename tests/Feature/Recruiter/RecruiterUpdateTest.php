<?php

namespace Tests\Feature\Recruiter;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RecruiterUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    public function verifyOrCreateRole()
    {
        if (! Role::where('name', 'recruiter')->exists()) {
            Role::create(['name' => 'recruiter']);

        }
    }

    public function test_update_specific_recruiter()
    {
        $this->verifyOrCreateRole();
        $user = User::factory()->create([

        ]);
        $user->assignRole('recruiter');
        $user->recruiter()->create([
            'company' => 'Apple',
            'sector' => 'TIC',

        ]);
        $data = ['name' => 'Nuevo nombre',
            'surname' => 'Nuevo apellido',
            'email' => fake()->email(),
            'company' => 'prueba update',
            'sector' => 'TOC', ];
        $this->actingAs($user, 'api');
        $idRecruiter = $user->recruiter->id;

        $response = $this->put(route('recruiter.update', [$idRecruiter]), $data);

        $user = $user->fresh();
        $user->recruiter->fresh();
        $this->assertEquals(ucfirst($user->name), $data['name']);
        $this->assertEquals(ucfirst($user->surname), $data['surname']);
        $this->assertEquals(ucfirst($user->recruiter->company), ucfirst($data['company']));
        $this->assertEquals(ucfirst($user->recruiter->sector), $data['sector']);

        $response->assertJson([
            'data' => [
                'name' => ucwords($user->name),
                'surname' => ucwords($user->surname),
                'company' => ucwords($user->recruiter->company),
                'sector' => ucwords($user->recruiter->sector)],
        ]);

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

    }

    public function test_attempting_to_update_another_recruiter()
    {
        $this->verifyOrCreateRole();
        $user = User::factory()->create([

        ]);
        $user->assignRole('recruiter');
        $user->recruiter()->create([
            'company' => 'Apple',
            'sector' => 'TIC',

        ]);
        $fakeID = fake()->numberBetween();

        $data = ['name' => 'Nuevo nombre',
            'surname' => 'Nuevo Apellido',
            'email' => fake()->email(),
            'company' => 'prueba update',
            'sector' => 'TOC', ];
        $this->actingAs($user, 'api');
        $response = $this->put(route('recruiter.update', [$fakeID]), $data);

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'Usuari no autenticat',
        ]);

        $response->assertUnauthorized();

        $response->assertStatus(401);
    }
}
