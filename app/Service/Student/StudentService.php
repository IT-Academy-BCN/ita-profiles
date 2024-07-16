<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\User;
use App\Models\Student;
use Exception;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\StudentNotFoundException;

class StudentService
{

	public function __construct()
	{
	}

	public function findUserByStudentID(string $studentID): User | Exception
	{
		// Fetch the Student model instance by id
		$student = Student::find($studentID);
		if (!$student) {
			throw new StudentNotFoundException($studentID);
		}

		// Fetch the User model associated with the Student's user_id
		$user = User::find($student->user_id);
		if (!$user) {
			throw new UserNotFoundException($student->user_id);
		}
		return $user;
	}
}
