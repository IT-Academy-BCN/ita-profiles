<?php
declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use App\Models\Student;
use App\Service\Student\UpdateStudentImageService;
use App\Exceptions\StudentNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateStudentImageServiceTest extends TestCase
{
    use DatabaseTransactions;

	protected UpdateStudentImageService $studentUpdateImageService;
	private string $photos_path = 'public/photos/';


    protected function setUp(): void
    {
        parent::setUp();
        $this->studentUpdateImageService = new UpdateStudentImageService();
    }




    public function testItUpdatesStudentImagePathInDatabase()
    {
        $student = Student::factory()->create();
        $studentId = $student->id;

        $initialPhoto = 'old_image.png';
        $student->photo = $initialPhoto;
        $student->save();

        $file = UploadedFile::fake()->image('test_image.png');
        $filename = 'new_image.png';

        $this->studentUpdateImageService->updateStudentImagePathInDatabaseByStudentID($studentId, $filename);

        $student->refresh();
        $this->assertEquals($filename, $student->photo);

        if ($initialPhoto) {
            $this->assertFalse(Storage::disk('public')->exists('photos/' . $initialPhoto));
        }
    }


    public function testCanThrowExceptionIfStudentIsNotFound()
    {
        $nonExistingStudentId = 'non_existing_id';
        $filename = 'new_image.png';

        $this->expectException(StudentNotFoundException::class);
        $this->studentUpdateImageService->updateStudentImagePathInDatabaseByStudentID($nonExistingStudentId, $filename);
    }


    public function testCanStoreImageInStorageByFilename()
    {
		$file = UploadedFile::fake()->image('test_image.png');
		$filename = 'test_image.png';

		$this->studentUpdateImageService->storePhotoInStorageByFileName($file, $filename);

		$this->assertTrue(Storage::disk('public')->exists('photos/' . $filename));
    }


}
