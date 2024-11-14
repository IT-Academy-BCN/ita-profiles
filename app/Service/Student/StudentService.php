<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\User;
use App\Models\Student;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\StudentNotFoundException;

class StudentService
{
	public function findUserByStudentID(string $studentID): User
	{
		$student = Student::find($studentID);
		if (!$student) {
			throw new StudentNotFoundException($studentID);
		}

		$user = User::find($student->user_id);
		if (!$user) {
			throw new UserNotFoundException($student->user_id);
		}
		return $user;
	}
}
