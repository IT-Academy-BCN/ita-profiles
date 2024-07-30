<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\{
    Student,
    User
};
use App\Service\Student\GetStudentImageService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\TestCase;

class GetStudentImageControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUser()
    {
        return User::factory()->create([
            'dni'=>'27827083G', 'password'=>'Password%123'
        ]);
    }

    private function createStudent(User $user):Student
    {
        return Student::factory()->for($user)->create();
    }

    private function getUserToken(User $user):string
    {   //hay que pasar lo datos manualmente porque el password es encriptado
        $singInUserData = ['dni'=>'27827083G', 'password'=>'Password%123'];
        $url = route('signin');
        $response = $this->json('POST', $url, $singInUserData);
        $token = $response->json('token');
        return $token;
    }

    public function test_get_student_image():void
    {
        $user = $this->createUser();
        $student = $this->createStudent($user);
        $token = $this->getUserToken($user);
        $studentId = $student->id;

        $url = route('student.photo.get', $studentId);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        $response->assertStatus(200);
    }

    public function test_get_student_image_not_found():void
    {
        $user = $this->createUser();
        $student = $this->createStudent($user);
        $student->photo = null;
        $student->save();
        $token = $this->getUserToken($user);
        $studentId = $student->id;

        $url = route('student.photo.get', $studentId);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    public function test_can_return_a_500_on_internal_server_error(): void
    {
        $this->mock(GetStudentImageService::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->andThrow(new \Exception('Internal Server Error'));
        });
        $user = $this->createUser();
        $student = $this->createStudent($user);
        $token = $this->getUserToken($user);
        $studentId = $student->id;

        $url = route('student.photo.get', $studentId);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        $response->assertStatus(500);
    }

}
