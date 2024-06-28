<?php
declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\Tag;

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
        
        
        $skills_array = json_decode($skills);
        
        $tags = Tag::whereIn('tag_name',$skills_array);
        
        $additionalTagsIds = $tags->pluck('id')->toArray();
        
        $resume->tags_ids = json_encode($additionalTagsIds);  
        $resume->update(); 
        
        return True;
        
	}
    
    
}
