<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Models\Collaboration;
use App\Models\Student;

class UpdateStudentCollaborationsService
{
    public function updateCollaborationsByStudentId(string $studentId, $updatedCollaborations): void
    {
        $student = Student::find($studentId);
        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $resume = $student->resume()->first();
        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }
		
		/*
        $collaborationsIds = json_decode($resume->collaborations_ids);
        $collaborations = Collaboration::findMany($collaborationsIds);

        foreach ($collaborations as $i => $collaboration) {
            if (isset($updatedCollaborations->collaborations[$i])) {
                $collaboration->collaboration_quantity = $updatedCollaborations->collaborations[$i];
            }
        }
        $collaborations->each->update();
        */
        
        $collaborations = $resume->collaborations->collect();
        foreach ($collaborations as $i => $collaboration) {
            if (isset($updatedCollaborations->collaborations[$i])) {
                $collaboration->collaboration_quantity = $updatedCollaborations->collaborations[$i];
            }
        }
        $collaborations->each->update();
    }
}
