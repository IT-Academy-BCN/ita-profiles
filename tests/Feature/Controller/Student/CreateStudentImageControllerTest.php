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

class CreateStudentImageControllerTest extends TestCase
{
    use DatabaseTransactions;

    private string $photos_path = 'public/photos/';

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function testItCreatesStudentImageSuccessfully()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->image('profile.png', 2, 2);

        $response = $this->putJson(route('student.createPhoto', $student->id), ['photo' => $file]);

        $response->assertStatus(200);

        $student->refresh();

        $fileContents = file_get_contents($file->path());

        $this->assertEquals($fileContents, Storage::get($this->photos_path . $student->photo));
    }

    public function testCanReturnErrorWhenNoImageIsUploaded()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson(route('student.createPhoto', $student->id), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }

    public function testCanReturnErrorWhenStudentIsNotFound()
    {
        $invalidStudentId = Str::uuid();

        $file = UploadedFile::fake()->image('profile.png');

        $response = $this->putJson(route('student.createPhoto', $invalidStudentId), [
            'photo' => $file,
        ]);

        $response->assertStatus(404);
    }

    public function testCanReturnErrorIfImageIsTooLarge()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->create('profile.png', 5000);

        $response = $this->putJson(route('student.createPhoto', $student->id), [
            'photo' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }

    public function testCanReturnErrorIfFileTypeIsNotSupported()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->putJson(route('student.createPhoto', $student->id), [ // Cambiar la ruta aquí
            'photo' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }
}
