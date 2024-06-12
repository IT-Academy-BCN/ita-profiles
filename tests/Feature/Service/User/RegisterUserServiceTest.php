<?php
declare(strict_types=1);

namespace Tests\Feature\Service\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Http\Requests\RegisterRequest;
use App\Models\Resume;
use App\Models\Student;
use App\Service\User\UserRegisterService;

class RegisterUserServiceTest extends TestCase
{
    use DatabaseTransactions; // Ensures that any database modifications made during testing are reverted once the test is complete

    private UserRegisterService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserRegisterService();
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

    public function test_user_can_be_instantiated(): void
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_student_can_be_instantiated(): void
    {
        $student = new Student();
        $this->assertInstanceOf(Student::class, $student);
    }

    public function test_resume_can_be_instantiated(): void
    {
        $resume = new Resume();

        $this->assertInstanceOf(Resume::class, $resume);
    }

    public function test_user_uuid_is_generated_when_user_is_created(): void
    {
        $userData = $this->createUserData();
        $user = User::create($userData);

        $this->assertNotEmpty($user->id);
    }

    public function test_student_uuid_is_generated_when_user_is_created(): void
    {
        $userData = $this->createUserData();
        $user = User::create($userData);
        $student = Student::create(['user_id' => $user->id]);

        $this->assertNotEmpty($student->id);
    }

    public function test_resume_uuid_is_generated_when_user_is_created(): void
    {
        $userData = $this->createUserData();
        $user = User::create($userData);
        $student = Student::create(['user_id' => $user->id]);
        $resume = new Resume;
        $resume->student_id = $student->id;
        $resume->specialization = $userData['specialization'] ?? null;
        $resume->save();

        $this->assertNotEmpty($resume->id);
    }

    public function test_user_creation_with_valid_data(): void
    {
        $userData = $this->createUserData();

        $response = $this->userService->createUser($userData);

        $this->assertEquals($userData['email'], $response['email']);
        $this->assertArrayHasKey('token', $response);
        $this->assertIsString($response['token']);
        $this->assertFalse(empty($response['token']) || empty($response['email']));
    }

    public function test_user_creation_with_invalid_data(): void
    {
        $registerData = [
            'username' => '',
            'dni' => 'invalidDNI',
            'specialization' => 'invalidSpecialization',
            'terms' => 'false',
            'email' => 'invalidemail',
            'password' => '123456',
        ];

        $success = $this->userService->createUser($registerData);

        $this->assertFalse($success);
    }

    public function test_user_creation_with_empty_data(): void
    {
        $registerData = [
            'username' => '',
            'dni' => '',
            'terms' => '',
            'specialization' => '',
            'email' => '',
            'password' => '',
        ];

        $success = $this->userService->createUser($registerData);

        $this->assertFalse($success);//Assert that the user creation was unsuccessful

    }

    /**
     * @dataProvider required_fields_for_user_creation_provider
     *
     * @param array $array Data array with user information to test.
     * @param bool $resultCorrect Expected result of the test (true if user creation should succeed, false otherwise).
     */
    public function test_required_fields_for_user_creation(array $array, bool $resultCorrect): void
    {
        $success = $this->userService->createUser($array);

    // Check if the result is as expected
        if ($resultCorrect) {
            $this->assertNotEmpty($success['email']);
            $this->assertNotEmpty($success['token']);
        } else {
            // If the result is expected to be incorrect, assert that the creation was unsuccessful
            $this->assertFalse($success);
        }
    }

    public static function required_fields_for_user_creation_provider(): array
    {
        return [
            // Missing 'username' field
            [
                [
                    'specialization' => 'Backend',
                    'terms' => 'true',
                    'email' => 'test@example.com',
                    'password' => 'password123',
                    'dni' => '27827083G',
                ],
                false,
            ],
            // Missing 'email' field
            [
                [
                    'username' => 'test_username',
                    'specialization' => 'Backend',
                    'terms' => 'true',
                    'password' => 'password123',
                    'dni' => '27827083G',
                ],
                false,
            ],
            // Missing 'password' field
            [
                [
                    'username' => 'test_username',
                    'specialization' => 'Backend',
                    'terms' => 'true',
                    'email' => 'janesmith@example.com',
                    'dni' => '27827083G',
                ],
                false,
            ],
            // Missing 'dni' field
            [
                [
                    'username' => 'test_username',
                    'specialization' => 'Backend',
                    'email' => 'alicebrown@example.com',
                    'terms' => 'true',
                    'password' => 'password123',
                ],
                false,
            ],
            // Missing 'specialization' field
            [
                [
                    'username' => 'Alice Brown',
                    'dni' => '27827083G',
                    'email' => 'alicebrown@example.com',
                    'terms' => 'true',
                    'password' => 'password123',
                ],
                false,
            ],
            // Missing 'terms' field
            [
                [
                    'username' => 'Alice Brown',
                    'dni' => '27827083G',
                    'email' => 'alicebrown@example.com',
                    'specialization' => 'Backend',
                    'password' => 'password123',
                ],
                true,
            ],
        ];
    }
}
