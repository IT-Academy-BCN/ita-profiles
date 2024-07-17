<?php
declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UpdateStudentImageService
{

	private string $photo_infix = '.profile_photo.';
	private string $photos_path = 'public/photos/';

    public function updateStudentImagePathInDatabaseByStudentID(string $studentID, string $filename): Student
	{
		$student = Student::find($studentID);

		if(!$student){
			throw new StudentNotFoundException($studentID);
		}

		if($student->photo){
			Storage::delete( $this->photos_path . $student->photo);
		}

		$student->photo = $filename;
		$student->update();

		return $student;

	}

	public function createImageNameByStudentIDAndFileHash(string $studentID, string $fileHashName): string
	{
		$filename = time() . ".". $studentID . $this->photo_infix . $fileHashName;
		return $filename;
	}


	public function storePhotoInStorageByFileName(UploadedFile $file, string $filename): void
	{
		$file->storeAs($this->photos_path, $filename);
	}

}
