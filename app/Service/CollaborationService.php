<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Student;
use App\Models\Collaboration;

class CollaborationService
{
    public function getCollaborationDetails($uuid)
    {
        $student = Student::where('id', $uuid)->with('resume')->firstOrFail();
        $resume = $student->resume;
        $collaborationIds = json_decode($resume->collaborations_ids);
        $collaborations = Collaboration::findMany($collaborationIds);

        return $collaborations->map(function ($collaboration) {
            return [
                'uuid' => $collaboration->id,
                'collaboration_name' => $collaboration->collaboration_name,
                'collaboration_description' => $collaboration->collaboration_description,
                'collaboration_quantity' => $collaboration->collaboration_quantity,
            ];
        });
    }
}
