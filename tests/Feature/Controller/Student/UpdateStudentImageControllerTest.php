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

class UpdateStudentImageControllerTest extends TestCase
{
    use DatabaseTransactions;
	private string $photos_path = 'public/photos/';


    protected function setUp(): void
	{
		parent::setUp();
		Storage::fake('public');
	}


    public function testItUpdatesStudentImageSuccessfully()
    {
       $user = User::factory()->create();
       $student = Student::factory()->create(['user_id' => $user->id]);

       Storage::fake('public');

       $file = UploadedFile::fake()->image('profile.png', 2, 2);

       $response = $this->postJson('/api/v1/student/'.$student->id.'/resume/photo', ['photo' => $file]);

       $response->assertStatus(200)
             ->assertJson([
                 'profile' => "La foto del perfil de l'estudiant s'actualitzat correctament"
             ]);

		$student->refresh();

		$fileContents = file_get_contents($file->path());

		$this->assertEquals($fileContents, Storage::get($this->photos_path . $student->photo));
	}


    public function testCanReturnErrorWhenNoImageIsUploaded()
    {
        $user = User::factory()->create();
		$user->save();
        $student = Student::factory()->create(['user_id'=>$user->id]);
		$student->save();

        $response = $this->postJson(route('student.updatePhoto', ['studentId' => $student->id]), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }



    public function testCanReturnErrorWhenStudentIsNotFound()
    {
        $invalidStudentId = Str::uuid();

        $file = UploadedFile::fake()->image('profile.png');

        $response = $this->postJson(route('student.updatePhoto', ['studentId' => $invalidStudentId]), [
            'photo' => $file,
        ]);

        $response->assertStatus(404);
    }



    public function testCanReturnErrorIfImageIsTooLarge()
    {
       $user = User::factory()->create();
       $user->save();
       $student = Student::factory()->create(['user_id' => $user->id]);
       $student->save();

       $file = UploadedFile::fake()->create('profile.png', 5000);

       $response = $this->postJson(route('student.updatePhoto', ['studentId' => $student->id]), [
           'photo' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['photo']);
    }




   public function testCanReturnErrorIfFileTypeIsNotSupported()
   {
      $user = User::factory()->create();
      $user->save();
      $student = Student::factory()->create(['user_id' => $user->id]);
      $student->save();

      $file = UploadedFile::fake()->create('document.pdf', 100);

      $response = $this->postJson(route('student.updatePhoto', ['studentId' => $student->id]), [
          'photo' => $file,
        ]);

       $response->assertStatus(422);
       $response->assertJsonValidationErrors(['photo']);
    }







}
