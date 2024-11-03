<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\{
    Student,
    User
};
use App\Service\Student\GetStudentImageService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetStudentImageControllerTest extends TestCase
{
    use DatabaseTransactions;
    private const PHOTOS_PATH = 'public/photos/';
    protected User $user;
    protected Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'dni'=>'27827083G', 'password'=>'Password%123'
        ]);

        $this->student =Student::factory()->for($this->user)->create();

    }

    public function testCanInstantiateAStudent(): void
    {
        $this->assertInstanceOf(Student::class, $this->student);
    }

    private function getUserToken():string
    {
        $singInUserData = ['dni'=>'27827083G', 'password'=>'Password%123'];
        $url = route('signin');
        $response = $this->json('POST', $url, $singInUserData);
        $token = $response->json('token');
        return $token;
    }

    public function testCanGetStudentImage():void
    {
        $student = $this->student;
        $token = $this->getUserToken();

        $url = route('student.photo.get', $student->id);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        $response->assertStatus(200);
        $response->assertJson(['photo' => Storage::url(self::PHOTOS_PATH . $student->photo)]);}

    public function testCanGetAnEmptyArrayWhenTheStudentHasNoPhoto():void
    {
        $student = $this->student;
        $student->photo = null;
        $student->save();
        $token = $this->getUserToken();

        $url = route('student.photo.get', $student->id);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        $response->assertStatus(200);
        $response->assertJson(['photo' => '']);
    }

    public function testCanReturns404WithInvalidStudentUuid(): void
    {
        $invalidUuid = 'invalidUuid';
        $token = $this->getUserToken();

        $url = route('student.photo.get', $invalidUuid);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        $response->assertStatus(404);
    }

}
