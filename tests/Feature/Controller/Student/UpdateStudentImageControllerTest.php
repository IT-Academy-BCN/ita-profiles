<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateStudentImageControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
	{
		parent::setUp();
		Storage::fake('public');
	}

    /** @test */
    public function it_updates_the_student_image_successfully()
    {
		$user = User::factory()->create();
		$user->save();
        $student = Student::factory()->create(['user_id'=>$user->id, 'id'=>(string) Str::uuid()]);
		$student->save();

        $file = UploadedFile::fake()->image('profile.png', 2,2);


        $response = $this->postJson('/api/v1/student/'.$student->id.'/resume/photo',['photo' => $file]);

        $response->assertStatus(200)
                 ->assertJson([
                     'profile' => 'La foto del perfil de l\'estudiant s\'actualitza correctament'
                 ]);

        $filename = $student->id . '.profile_photo.' . $file->hashName();

        $student->refresh();
        $this->assertEquals($filename, $student->photo);
    }

    /** @test */
    public function it_returns_an_error_if_no_photo_is_uploaded()
    {
        $user = User::factory()->create();
		$user->save();
        $student = Student::factory()->create(['user_id'=>$user->id]);
		$student->save();

        $response = $this->postJson(route('student.updatePhoto', ['studentId' => $student->id]), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }

    /** @test */
    public function it_returns_an_error_if_the_student_is_not_found()
    {
        $invalidStudentId = Str::uuid();

        $file = UploadedFile::fake()->image('profile.png');

        $response = $this->postJson(route('student.updatePhoto', ['studentId' => $invalidStudentId]), [
            'photo' => $file,
        ]);

        $response->assertStatus(404);
    }
}
