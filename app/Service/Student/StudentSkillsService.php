<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\AdditionalTraining;

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
        
        $additionalTrainings = AdditionalTraining::where('course_name',$skills_array);
        
        $additionalTrainingIds = $additionalTrainings->pluck('id')->toArray();
        
        $resume->additional_trainings_ids = json_encode($additionalTrainingIds);   
        
        return True;
        
	}
	
	
    public function updateSkillsByStudentIdOld(string $studentId, string $skills): Exception | bool
    {
		
		if(json_decode($skills) == null AND $skills != "[]"){
			return False;
		}

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
    /*
    public function getSkillsByStudentId(string $studentId): array | Exception
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

        $skills = json_decode($resume->skills, False);

        return (array) $skills;
    }*/
    
    public function fieldIsValidSkillsJson(string $field):  bool
    {
		$result = json_decode($field, True);
		
		/*if($result == Null){
			return False;
		}*/

		
		try{
			
			if(is_array($result))
			{
				//Check if the array is multidimensional:
				if (count($result) == count($result, COUNT_RECURSIVE)) 
				{
				  //echo 'array is not multidimensional';
				  return True;
				}
				else
				{
				  //echo 'array is multidimensional';
				  return False;
				}
			}else{
				return False;
			}
			
		}catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return False;
		}
	}
    
    
}
