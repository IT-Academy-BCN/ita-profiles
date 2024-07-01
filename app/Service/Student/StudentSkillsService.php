<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class StudentSkillsService
{

    public function updateSkillsByStudentId(string $studentId, string $skills): Exception | bool
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
            //return False;
        }

        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
            //return False;
        }

        $resume->skills = $skills;
		$resume->save();

        //return (array) $modality;
        return True;
    }
    
    public function getSkillsByStudentId(string $studentId, string $skills): array | Exception
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
            //return False;
        }

        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
            //return False;
        }

        $skills = $resume->skills;

        return (array) $skills;
    }
    
    
    
}
