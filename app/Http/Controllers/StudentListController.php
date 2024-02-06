<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Resources\StudentListResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentListController extends Controller
{
    public function __invoke()
    {
        $studentsList = Student::all();

        if (! $studentsList) {
            throw new HttpResponseException(response()->json([
                'message' => __('Alguna cosa ha anat malament.Intenta-ho de nou més tard.')
            ], 404));
        } elseif ($studentsList->isEmpty()) {
            throw new HttpResponseException(response()->json([
                'message' => __('No hi ha estudiants a la base de dades.')
            ], 404));
        }

        $studentsList = $studentsList->map(function ($student) {
            return new StudentListResource($student);
        });

        return response()->json(['data' => $studentsList], 200);
    }
}
