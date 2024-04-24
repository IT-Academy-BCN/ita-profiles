<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\StudentDetailsNotFoundException;
use App\Models\Resume;


class StudentDetailsService
{
    public function execute($student)
    {
        return $this->getStudentDetailsById($student);
    }
    

    public function getStudentDetailsById($student){
        $studentDetails = Resume::where('student_id', $student)->get();
        if(!$studentDetails->isEmpty()){
            throw new StudentDetailsNotFoundException($student);
        }
        return $studentDetails;
        
    }

}
