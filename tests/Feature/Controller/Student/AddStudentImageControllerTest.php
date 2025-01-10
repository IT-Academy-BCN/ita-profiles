<?php
declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;

class AddStudentImageControllerTest extends TestCase
{
    use DatabaseTransactions;
    private string $photos_path = 'public/photos/';
    protected User $user;
    protected Student $student;
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
        $this->student = Student::factory()->create(['user_id' => $this->user->id]);
    }



    public function testItAddsStudentImageSuccessfully()
    {
        $file = UploadedFile::fake()->image('profile.png', 2, 2);

        $response = $this->postJson(route('student.addPhoto', $this->student->id), ['photo' => $file]);
        $response->assertStatus(200);

        $this->student->refresh();
        $fileContents = file_get_contents($file->path());
        $this->assertEquals($fileContents, Storage::get($this->photos_path . $this->student->photo));
    }
    public function testCanReturnUnprocessableEntityErrorWhenNoImageIsUploaded()
    {
        $response = $this->postJson(route('student.addPhoto', $this->student->id), []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }
    public function testCanReturnNotFoundErrorWhenStudentIsMissing()
    {
        $invalidStudentId = Str::uuid();
        $file = UploadedFile::fake()->image('profile.png');
        $response = $this->postJson(route('student.addPhoto', $invalidStudentId), [
            'photo' => $file,
        ]);
        $response->assertStatus(404);
    }
    public function testCanReturnErrorIfImageIsTooLarge()
    {
        $file = UploadedFile::fake()->create('profile.png', 5000);
        $response = $this->postJson(route('student.addPhoto', $this->student->id), [
            'photo' => $file,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }
    public function testCanReturnErrorIfFileTypeIsNotSupported()
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);
        $response = $this->postJson(route('student.addPhoto', $this->student->id), [
            'photo' => $file,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }

}
