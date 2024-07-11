<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Student;
use Illuminate\Support\Str;

class UpdateStudentImageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
{
    parent::setUp();
    Storage::fake('public');
}

    /** @test */
    public function it_updates_the_student_image_successfully()
    {
        $student = Student::factory()->create();

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->postJson(route('student.updatePhoto', ['studentId' => $student->id]), [
            'photo' => $file,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'profile' => 'La foto del perfil de l\'estudiant s\'actualitza correctament'
                 ]);

                 Storage::disk('public')->self::assertFileExists('photos/' . $file->hashName());

        $student->refresh();
        $this->assertEquals($file->hashName(), $student->photo);
    }

    /** @test */
    public function it_returns_an_error_if_no_photo_is_uploaded()
    {
        $student = Student::factory()->create();

        $response = $this->postJson(route('student.updatePhoto', ['studentId' => $student->id]), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }

    /** @test */
    public function it_returns_an_error_if_the_student_is_not_found()
    {
        $invalidStudentId = Str::uuid();

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->postJson(route('student.updatePhoto', ['studentId' => $invalidStudentId]), [
            'photo' => $file,
        ]);

        $response->assertStatus(404);
    }
}
