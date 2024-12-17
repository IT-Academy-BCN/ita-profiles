<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class RegisterUserControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUserData(): array
    {
        return [
            'username' => 'test_username',
            'dni' => '27827083G',
            'email' => 'test_email@test.com',
            'terms' => 'true',
            'password' => 'Password%123',
            'specialization' => 'Backend',
            'password_confirmation' => 'Password%123',
        ];
    }

    public function test_user_registration_with_valid_data(): void
    {
        $userData = $this->createUserData();
        $response = $this->json('POST', '/api/v1/register', $userData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'token',
            'email'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => $userData['username'],
            'dni' => $userData['dni'],
            'email' => $userData['email'],
        ]);

        // Additional assertions for related models
        $user = User::where('email', $userData['email'])->first();
        $this->assertDatabaseHas('students', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('resumes', [
            'student_id' => $user->student->id,
            'specialization' => $userData['specialization'],
        ]);
    }

    public function test_user_registration_with_invalid_data(): void
    {
        $response = $this->json('POST', '/api/v1/register', [
            'username' => 667677,
            'dni' => 'Invalid DNI',
            'email' => 'invalid_email',
            'terms' => 'false',
            'password' => 'invalid_password',
            'password_confirmation' => 'invalid_password_confirmation',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['username', 'dni', 'email', 'password']);
    }

    /**
     * @dataProvider required_fields_for_user_creation_provider
     *
     * @param array $data Data array with user information to test.
     * @param bool $shouldSucceed Expected result of the test (true if user creation should succeed, false otherwise).
     */
    public function test_required_fields_for_user_creation(array $data, bool $shouldSucceed): void
    {
        $response = $this->json('POST', '/api/v1/register', $data);

        if ($shouldSucceed) {
            $response->assertStatus(201);
            $response->assertJsonStructure(['token', 'email']);

            $this->assertDatabaseHas('users', [
                'username' => $data['username'] ?? null,
                'dni' => $data['dni'] ?? null,
                'email' => $data['email'] ?? null,
            ]);

            $user = User::where('email', $data['email'])->first();
            $this->assertDatabaseHas('students', ['user_id' => $user->id]);
            if (isset($data['specialization'])) {
                $this->assertDatabaseHas('resumes', [
                    'student_id' => $user->student->id,
                    'specialization' => $data['specialization'],
                ]);
            }
        } else {
            $response->assertStatus(422);

            $validationErrors = $response->json('errors');

            foreach (array_keys($data) as $key) {
                if (empty($data[$key])) {
                    $this->assertArrayHasKey($key, $validationErrors);
                }
            }
        }
    }

    /**
     * Proveedor de datos para campos obligatorios en el registro de usuario.
     */
    public static function required_fields_for_user_creation_provider(): array
    {
        return [
            // Campo 'username' faltante
            [
                [
                    'dni' => '27827083G',
                    'email' => 'test@example.com',
                    'terms' => 'true',
                    'password' => 'Password%123',
                    'specialization' => 'Backend',
                    'password_confirmation' => 'Password%123',
                ],
                false,
            ],

            // Campo 'email' faltante
            [
                [
                    'username' => 'test_username',
                    'dni' => '27827083G',
                    'terms' => 'true',
                    'password' => 'Password%123',
                    'specialization' => 'Backend',
                    'password_confirmation' => 'Password%123',
                ],
                false,
            ],

            // Campo 'password' faltante
            [
                [
                    'username' => 'test_username',
                    'dni' => '27827083G',
                    'email' => 'janesmith@example.com',
                    'terms' => 'true',
                    'specialization' => 'Backend',
                    'password_confirmation' => 'Password%123',
                ],
                false,
            ],

            // Campo 'dni' faltante
            [
                [
                    'username' => 'test_username',
                    'email' => 'alicebrown@example.com',
                    'terms' => 'true',
                    'password' => 'Password%123',
                    'specialization' => 'Backend',
                    'password_confirmation' => 'Password%123',
                ],
                false,
            ],

            // Campo 'specialization' faltante
            [
                [
                    'username' => 'Alice Brown',
                    'dni' => '27827083G',
                    'email' => 'alicebrown@example.com',
                    'terms' => 'true',
                    'password' => 'Password%123',
                    'password_confirmation' => 'Password%123',
                ],
                false,
            ],

            // Campo 'terms' faltante
            [
                [
                    'username' => 'Alice Brown',
                    'dni' => '27827083G',
                    'email' => 'alicebrown@example.com',
                    'password' => 'Password%123',
                    'specialization' => 'Backend',
                    'password_confirmation' => 'Password%123',
                ],
                false,
            ],

            // Campo 'password_confirmation' faltante
            [
                [
                    'username' => 'Alice Brown',
                    'dni' => '27827083G',
                    'email' => 'alicebrown@example.com',
                    'terms' => 'true',
                    'password' => 'Password%123',
                    'specialization' => 'Backend',
                ],
                false,
            ],
        ];
    }
}
