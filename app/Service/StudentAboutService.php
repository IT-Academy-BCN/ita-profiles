<?php
namespace App\Service;

use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class StudentAboutService
{
    /*
    public function execute(?string $id = null):string
    {
        $resumes = $this->getResumes($specializations, $tags);

        return $this->mapResumesToData($resumes);
    }*/

    public function getAboutByStudentId(string $student_id): string
    {
        $student= Resume::find($student_id);

        if ($student !=null) {
            $about = $student->about;
        }else {
            throw new ModelNotFoundException(__('No hi ha about'), 404);
        }

        return $about;
    }



}

?>