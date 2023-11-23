<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    public function verifyOrCreateRole()
    {
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }
    }

    public function test_create_admin_with_valid_data()
    {
        $this->verifyOrCreateRole();

        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '53671299V',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/v1/admins', $userData);
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'surname' => $userData['surname'],
            'dni' => $userData['dni'],
            'email' => $userData['email'],
        ]);

        $this->assertDatabaseHas('admins', [
            'user_id' => User::where('email', $userData['email'])->first()->id,
        ]);

        $user = User::where('email', $userData['email'])->first();
        $this->assertTrue($user->hasRole('admin'));

        $response->assertJson([
            'message' => __('Registre realitzat amb èxit.'),
        ]);
        $response->assertHeader('Content-Type', 'application/json');

    }

    public function test_can_create_admin_with_bad_name()
    {
        $this->verifyOrCreateRole();

        $userData = [
            'name' => 'J@hn',
            'surname' => 'Doe',
            'dni' => '53671299V',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/v1/admins', $userData);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
            ],
        ])
            ->assertJson([
                'errors' => [
                    'name' => [
                        'El format de nom és invàlid.',
                    ],
                ],
            ]);

    }

    public function test_can_create_admin_with_bad_surname()
    {
        $this->verifyOrCreateRole();

        $userData = [
            'name' => 'John',
            'surname' => 'Doe67',
            'dni' => '53671299V',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/v1/admins', $userData);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'surname',
            ],
        ])
            ->assertJson([
                'errors' => [
                    'surname' => [
                        'El format de cognom és invàlid.',
                    ],
                ],
            ]);

    }

    public function test_can_create_admin_with_bad_dni()
    {
        $this->verifyOrCreateRole();

        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '53671299x',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/v1/admins', $userData);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'dni',
            ],
        ])
            ->assertJson([
                'errors' => [
                    'dni' => [
                        'No és un Dni vàlid',
                    ],
                ],
            ]);

    }

    public function test_can_create_admin_with_bad_email()
    {
        $this->verifyOrCreateRole();

        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '53671299V',
            'email' => 'johnexample.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/v1/admins', $userData);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'email',
            ],
        ])
            ->assertJson([
                'errors' => [
                    'email' => [
                        'Adreça electrònica no és un e-mail vàlid',
                    ],
                ],
            ]);

    }

    public function test_can_create_admin_with_bad_password()
    {
        $this->verifyOrCreateRole();

        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'dni' => '53671299V',
            'email' => 'john@example.com',
            'password' => 'passwor',
        ];

        $response = $this->post('/api/v1/admins', $userData);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'password',
            ],
        ])
            ->assertJson([
                'errors' => [
                    'password' => [
                        'Contrasenya ha de contenir almenys 8 caràcters.',
                    ],
                ],
            ]);

    }

    public function test_it_returns_a_list_of_admins()
    {
        $this->verifyOrCreateRole();

        $user = User::factory()->create();
        $admin = Admin::create(['user_id' => $user->id]);
        $user->assignRole('admin');

        $this->actingAs($user, 'api');

        $response = $this->get('/api/v1/admins');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'surname',
                    'email',
                ],
            ],
        ]);
    }

    public function test_can_return_empty_data()
    {
        $this->verifyOrCreateRole();

        $user = User::factory()->create();

        $user->assignRole('admin');

        $this->actingAs($user, 'api');
        $response = $this->get('/api/v1/admins');
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);

        $response->assertJson([
            'message' => 'No hi ha administradors a la base de dades',
        ]);

    }

    public function test_can_Show_specific_admin()
    {

        $this->verifyOrCreateRole();

        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user, 'api');

        $admin = Admin::create(['user_id' => $user->id]);

        $response = $this->get("/api/v1/admins/{$admin->id}");

        $response->assertStatus(200);

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'surname', 'email',
            ],
        ]);
    }

    public function test_can_show_specific_admin_invalid_data()
    {

        $this->verifyOrCreateRole();

        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user, 'api');

        $admin = Admin::create(['user_id' => $user->id]);
        $user2 = User::factory()->create();
        $admin2 = Admin::create(['user_id' => $user2->id]);

        $response = $this->get("/api/v1/admins/{$admin2->id}");

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'No tens permisos per veure aquest usuari.',
        ]);

        $response->assertHeader('Content-Type', 'application/json');

    }

    public function test_update_specify_admin()
    {
        $this->verifyOrCreateRole();

        $user = User::factory()->create();

        $user->assignRole('admin');

        $this->actingAs($user, 'api');

        $admin = Admin::create(['user_id' => $user->id]);

        $response = $this->put("/api/v1/admins/{$admin->id}", [
            'name' => 'Nuevo Nombre',
            'surname' => 'Nuevo Apellido',
            'email' => 'nuevo@example.com',
        ]);

        $response->assertHeader('Content-Type', 'application/json');

        $response->assertStatus(200);

    }

    public function test_can_update_invalid_user()
    {
        $this->verifyOrCreateRole();

        $user = User::factory()->create();

        $user->assignRole('admin');

        $this->actingAs($user, 'api');

        $admin = Admin::create(['user_id' => $user->id]);

        $user2 = User::factory()->create();
        $admin2 = Admin::create(['user_id' => $user2->id]);

        $response = $this->put("/api/v1/admins/{$admin2->id}", [
            'name' => 'Nuevo Nombre',
            'surname' => 'Nuevo Apellido',
            'email' => 'nuevo@example.com',
        ]);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson(['message' => 'No tens permís per modificar aquest usuari']);

        $response->assertStatus(401);
    }

    public function test_can_destroy_destroy()
    {
        $this->verifyOrCreateRole();
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user, 'api');

        $admin = Admin::create(['user_id' => $user->id]);

        $response = $this->delete("/api/v1/admins/{$admin->id}");

        $response->assertHeader('Content-Type', 'application/json');

        $response->assertStatus(200);

        $this->assertDatabaseMissing('admins', [
            'id' => $admin->id,
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        $response->assertJson([
            'message' => 'La seva compte ha estat eliminada amb èxit',
        ]);
    }

    public function test_can_destroy_dont_have_permissions()
    {
        $this->verifyOrCreateRole();

        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user, 'api');
        $admin = Admin::create(['user_id' => $user->id]);

        $user2 = User::factory()->create();
        $admin2 = Admin::create(['user_id' => $user2->id]);

        $response = $this->delete("/api/v1/admins/{$admin2->id}");
        $response->assertStatus(401);
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertJson([
            'message' => 'No tens permís per eliminar aquest usuari',
        ]);
    }
}
