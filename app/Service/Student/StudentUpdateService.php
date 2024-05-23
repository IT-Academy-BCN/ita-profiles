<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentUpdateService
{
    public function execute(UpdateStudentRequest $request, $studentId)
    {
        return $this->updateStudentById($request, $studentId);
    }

public function updateStudentById(UpdateStudentRequest $request, $studentId)
{
    $student = $this->findStudentById($studentId);

    $updatedStudent = DB::transaction(function () use ($request, $student) {

        $student->name = ($request->name);
        $student->surname = ($request->surname);
        $student->resume->subtitle = $request->subtitle;
        $student->resume->linkedin = ($request->linkedin);
        $student->resume->github = ($request->github);

        $student->save();

        return $student;
    });

    if (! $updatedStudent) {
        throw new HttpResponseException(response()->json(['message' => __('Alguna cosa ha anat malament.
            Torna-ho a intentar més tard.')], 404));
    }

    return response()->json(
        [
            'data' => StudentResource::make($updatedStudent)],
        200,
    );
}
        public function findStudentById($studentId)
        {
            $student = Student::find($studentId);

            if (!$student) {
                throw new StudentNotFoundException($studentId);
            }

            $resume = $student->resume()->first();

            if (!$resume) {
                throw new ResumeNotFoundException($studentId);
            }

            return $student;
        }
    }
